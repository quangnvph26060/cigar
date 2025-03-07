<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ConfigPayment;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function checkout()
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!auth()->check()) {
            // Lưu lại URL hiện tại vào session
            session()->put('url.intended', url()->current());

            // Chuyển hướng đến trang login
            return redirect()->route('login');
        }

        if (Cart::instance('shopping')->count() <= 0) {
            return redirect()->route('cartList');
        }

        $paymentMethods = ConfigPayment::query()->where('published', 1)->get();

        $carts = Cart::instance('shopping')->content();

        return view('frontend.pages.checkout', compact('carts', 'paymentMethods'));
    }


    public function postCheckout(Request $request)
    {
        $credentials = $request->validate([
            'username'       => 'required|string|max:255',
            'address'        => 'required|string|max:500',
            'phone'          => ['required', 'regex:/^(\+?[0-9]{1,4})?([0-9]{10,15})$/'],
            'email'          => 'required|email|max:255',
            'payment_method' => 'required|in:cod,bacs', // Chỉ chấp nhận 3 phương thức thanh toán
            'notes'           => 'nullable'
        ], [
            'username.required' => 'Vollständiger Name ist erforderlich.',
            'address.required'  => 'Adresse ist erforderlich.',
            'phone.required'    => 'Telefonnummer ist erforderlich.',
            'email.required'    => 'E-Mail ist erforderlich.',
            'payment_method.required' => 'Zahlungsmethode ist erforderlich.',
            'payment_method.in' => 'Ungültige Zahlungsmethode.',
            'phone.regex' => 'Ungültige Telefonnummer.',
        ], [
            'username'       => 'Vollständiger Name',
            'address'        => 'Adresse',
            'phone'          => 'Telefonnummer',
            'email'          => 'E-Mail',
            'payment_method' => 'Zahlungsmethode',
        ]);


        // Kiểm tra nếu giỏ hàng rỗng
        if (Cart::instance('shopping')->count() == 0) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        try {
            DB::beginTransaction(); // Bắt đầu transaction

            $credentials['code']            = 'DH' . time();
            $credentials['user_id']         = auth()->id();
            $credentials['total_amount']    = Cart::instance('shopping')->subTotal();

            $order = Order::create($credentials);

            // Lưu sản phẩm vào bảng `order_details`
            foreach (Cart::instance('shopping')->content() as $cartItem) {
                OrderDetail::create([
                    'order_id'       => $order->id,
                    'product_id'     => $cartItem->options->product_id,
                    'variation_id'   => $cartItem->options->variant_id, // Nếu có variation thì cập nhật
                    'price_variant_id' => $cartItem->id, // Nếu có price_variant_id thì cập nhật
                    'p_name'         => $cartItem->name,
                    'p_image'        => $cartItem->options->image ?? null,
                    'p_price'        => $cartItem->price,
                    'p_qty'          => $cartItem->qty,
                    'p_unit'         => $cartItem->options->unit ?? '',
                ]);
            }

            DB::commit(); // Lưu thay đổi vào database

            // Xóa giỏ hàng sau khi đặt hàng thành công
            Cart::instance('shopping')->destroy();

            // Chuyển hướng về trang thành công
            return redirect()->route('orderSuccess', $order->code)->with('success', 'Đơn hàng đã được đặt thành công!');
        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác nếu có lỗi
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại!')->withInput();
        }
    }

    public function orderSuccess($code)
    {
        if (!auth()->check()) {
            // Lưu lại URL hiện tại vào session
            session()->put('url.intended', url()->current());

            // Chuyển hướng đến trang login
            return redirect()->route('login');
        }
        $order = Order::query()->with('orderDetails')->where('code', $code)->firstOrFail();

        return view('frontend.pages.order-success', compact('order'));
    }
}
