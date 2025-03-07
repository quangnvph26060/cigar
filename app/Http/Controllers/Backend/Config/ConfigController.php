<?php

namespace App\Http\Controllers\Backend\Config;

use App\Http\Controllers\Controller;
use App\Http\Requests\Config\ConfigRequest;
use App\Models\Attribute;
use App\Models\Config;
use App\Models\ConfigFilter;
use App\Models\ConfigPayment;
use App\Services\BaseQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfigController extends Controller
{

    protected $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new BaseQuery(ConfigFilter::class);
    }
    public function config()
    {
        return view('backend.config.save');
    }

    public function postConfig(ConfigRequest $request)
    {
        return transaction(function () use ($request) {
            $credentials = $request->validated();

            $config = Config::query()->first();

            if ($request->hasFile('logo')) {
                $credentials['logo'] = saveImages($request, 'logo', 'logo');
                deleteImage($config->logo);
            }

            if ($request->hasFile('icon')) {
                $credentials['icon'] = saveImages($request, 'icon', 'icon');
                deleteImage($config->icon);
            }

            $config->update($credentials);

            return handleResponse('Lưu thay đổi thành công.', 200);
        });
    }

    public function payment($id = null)
    {
        $configPayments = ConfigPayment::query();
        if ($id) {
            $configPayment = $configPayments->where('type', 'bacs')->first();
            $banks = DB::table('banks')->pluck('name', 'bin')->toArray();

            return view('backend.config.transfer_payment', compact('banks', 'configPayment'));
        }
        $configPayments = $configPayments->get();
        return view('backend.config.payment', compact('configPayments'));
    }

    public function handleChangePublishPayment(Request $request)
    {

        try {
            $configPayment = ConfigPayment::find($request->id);

            $configPayment->published = !$configPayment->published;

            $configPayment->save();

            return response()->json(['status' => true, 'published' => $configPayment->published, 'message' => 'Cập nhật thành công.']);
        } catch (\Exception $e) {
            logInfo('Đã có lỗi xảy ra:' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'Đã có lỗi xảy ra. Vui lòng thử lại sau!'], 500);
        }
    }

    public function configTransferPayment(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable',
            'account_details.account_name' => 'required|array',
            'account_details.account_name.*' => 'required|string|max:255',
            'account_details.account_number' => 'required|array',
            'account_details.account_number.*' => 'required|numeric|digits_between:6,20',
            'account_details.bank_code' => 'required|array',
            'account_details.bank_code.*' => 'required|string|distinct',
        ], __('request.messages'));

        $config = ConfigPayment::query()->where('id', 2)->first();

        $config->update($credentials);

        toastr()->success('Lưu thay đổi thành công.');

        return redirect()->route('admin.configs.payment');
    }

    public function filter()
    {

        if (request()->ajax()) {
            DB::reconnect();
            $columns    = ['id', 'filter_type', 'title', 'attribute_id', 'option_price', 'selection_type'];

            $query      = $this->queryBuilder->buildQuery(
                $columns,
                [],
                [],
                request(),
                null,
                [],
                ['location', 'asc']
            );

            return $this->queryBuilder->processDataTable($query, function ($dataTable) {
                return $dataTable
                    ->addColumn('title', function ($row) {
                        return "<strong class='text-primary'>$row->title</strong>
                        <br/>
                        <button class='btn-edit p-0 text-primary'
                            style='outline: none; border: none; background: none;'
                            data-resource='" . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . "'>
                            sửa
                        </button>";
                    })
                    ->addColumn('attribute_id', function ($row) {
                        if (!empty($row->attribute->name)) {
                            return $row->attribute->name;
                        } elseif (!empty($row->option_price)) {
                            return $row->option_price;
                        } else {
                            return '---';
                        }
                    })
                    ->addColumn('checkbox', function ($row) {
                        return '<input type="checkbox" class="row-checkbox" value="' . $row->id . '" />';
                    });
            }, ['title', 'checkbox']);
        }
        $attributes = Attribute::query()->pluck('name', 'id')->toArray();
        return view('backend.config.filter', compact('attributes'));
    }

    public function handleSubmitChangeFilter(Request $request, string $id)
    {
        $credentials = $request->validate([
            'filter_type' => 'required|in:attribute,brand,price',
            'title' => 'required|unique:config_filters,title,' . $id,
            'attribute_id' => 'nullable|exists:attributes,id',
            'option_price' => 'nullable|string',
            'selection_type' => 'nullable|in:radio,checkbox',
        ]);

        if (!$data  = configFilter::query()->find($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bản ghi trên hệ thống!'
            ], 401);
        }

        $data->update($credentials);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật bộ lọc thành công!'
        ]);
    }

    public function handleSubmitFilter(Request $request)
    {
        $credentials = $request->validate([
            'filter_type' => 'required|in:attribute,brand,price',
            'title' => 'required|unique:config_filters',
            'attribute_id' => 'nullable|exists:attributes,id',
            'option_price' => 'nullable|string',
            'selection_type' => 'nullable|in:radio,checkbox',
        ]);

        configFilter::create($credentials);

        return response()->json([
            'success' => true,
            'message' => 'Thêm bộ lọc thành công'
        ]);
    }
}
