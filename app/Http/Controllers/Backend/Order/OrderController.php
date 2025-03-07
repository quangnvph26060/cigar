<?php

namespace App\Http\Controllers\Backend\Order;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatus;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Services\BaseQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderController extends Controller
{

    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(Order::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $columns    = ['code', 'id', 'username', 'email', 'payment_method', 'phone', 'total_amount', 'order_status', 'created_at', 'payment_status'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request(),
                null,
                [],
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->addColumn('total_amount', function ($row) {
                        return  getFormattedSubTotal($row->total_amount) . ' $';
                    })
                    ->addColumn('email', function ($row) {
                        return "
                    <p>$row->username</p>
                    <p>$row->email</p>
                    <p>$row->phone</p>
                    ";
                    })
                    ->addColumn('code', function ($row) {
                        return '<a href="' . route('admin.orders.show', $row) . '">' . $row->code . '</a>';
                    })
                    ->addColumn('payment_method', function ($row) {
                        if ($row->payment_method == 'cod') {
                            return 'Thanh toán khi nhận hàng (COD)';
                        } elseif ($row->payment_method == 'bacs') {
                            return 'Thanh toán chuyển khoản';
                        } else {
                            return 'Thanh toán đặt cọc';
                        };
                    })
                    ->addColumn('order_status', function ($row) {
                        return statusColor($row->order_status);
                    })
                    ->addColumn('payment_status', function ($row) {
                        return paymentStatus($row->payment_status);
                    })
                    ->addColumn('created_at', function ($row) {
                        return Carbon::parse($row->created_at)->format('d/m/Y');
                    });
            }, ['code', 'email', 'payment_method', 'order_status', 'payment_status']);
        }

        return view('backend.order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('orderDetails');
        return view('backend.order.detail', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function exportPDF(Request $request)
    {
        $orderId = $request->input('order_id');

        $order = Order::with('orderDetails')->find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Đơn hàng không tồn tại!'], 404);
        }

        // Kiểm tra nếu đơn hàng chưa được xác nhận thì không cho in hóa đơn
        if ($order->order_status !== 'confirmed' && $order->order_status !== 'completed') {
            return response()->json(['error' => 'Đơn hàng chưa được xác nhận, không thể in hóa đơn!'], 400);
        }

        $route = route('orderSuccess', $order->code);

        $qrCode = base64_encode(QrCode::format('png')
            ->size(200)
            ->generate($route));

        $pdf = Pdf::loadView('backend.invoices.template', compact('order', 'qrCode'));

        return $pdf->download('hoa-don-' . $orderId . '.pdf');
    }


    public function changeOrderStatus(Request $request)
    {
        $order = Order::query()->with('orderDetails')->findOrFail($request->orderId);

        if ($order->order_status == 'pending') {
            // Đổi từ pending -> confirmed
            $order->order_status = 'confirmed';
            $order->save();

            // Gửi email thông báo khi đơn hàng được xác nhận
            Mail::to($order->email)->send(new OrderStatusMail($order));
        } elseif ($order->order_status == 'confirmed') {
            // Kiểm tra thanh toán trước khi hoàn thành đơn hàng
            if ($order->payment_status != 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Vui lòng xác nhận thanh toán trước khi hoàn tất đơn hàng!'
                ], 400);
            }

            // Nếu đã thanh toán, chuyển sang completed
            $order->order_status = 'completed';
            $order->save();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Trạng thái đơn hàng không hợp lệ để cập nhật!'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'value' => $order->order_status
        ]);
    }

    public function cancelOrder(Request $request, string $id)
    {
        $request->validate(
            [
                'reason' => 'required|min:5|max:100'
            ]
        );

        $order = Order::query()->findOrFail($id);

        if ($order->status == 'completed') {
            return response()->json([
                'status' => false,
                'message' => 'Không thể hủy khi đơn hàng đã hoàn thành.'
            ]);
        }

        $order->order_status = 'cancelled';
        $order->reason = $request->reason;
        $order->updated_at = now();

        $order->save();

        Mail::to($order->email)->send(new OrderStatusMail($order));

        return response()->json([
            'status' => true,
            'message' => 'Đơn hàng đã hủy thành công.',
            'reason' => $order->reason
        ]);
    }

    public function confirmPayment(string $id)
    {
        $order = Order::query()->findOrFail($id);

        if ($order->order_status == 'pending') {
            return response()->json([
                'status' => false,
                'message' => 'Đơn hàng chưa được xác nhận.'
            ], 400);
        }

        $order->payment_status = 1;
        $order->updated_at = now();
        $order->save();

        return response()->json([
            'status' => true,
            'message' => 'Xác nhận thanh toán thành công.'
        ]);
    }
}
