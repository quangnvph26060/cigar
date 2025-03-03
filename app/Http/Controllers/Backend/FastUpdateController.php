<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\error;

class FastUpdateController extends Controller
{
    public function handleFastUpdate(Request $request)
    {
        $modelClass = 'App\\Models\\' . $request->model;
        Log::info($request->model);

        if (!class_exists($modelClass)) {
            return errorResponse('Model không hợp lệ', 400);
        }

        switch ($request->model) {
            case 'Brand':
                return $this->fastUpdateBrand($request, $modelClass);
            case 'Product':
                return $this->fastUpdateProduct($request, $modelClass);

            default:
                # code...
                break;
        }
    }

    protected function fastUpdateBrand($request, $modelClass)
    {
        $credentials = $request->validate(
            [
                'name' => 'required|unique:brands,name,' . $request->id,
                'image' => 'nullable|image|mimes:png,jpg,webp',
                'status' => 'nullable'
            ],
            __('request.messages'),
            [
                'name' => 'Tên thương hiệu',
                'image' => 'Ảnh'
            ]
        );

        return transaction(function () use ($request, $credentials, $modelClass) {

            if (!$table = $modelClass::query()->find($request->id)) return errorResponse('Không tìm thấy bản ghi phù hợp', 404);

            if (isset($credentials['image'])) {
                $credentials['image'] = saveImages($request, 'image', 'categories');
                deleteImage($table->image);
            }

            $credentials['status'] = isset($credentials['status']) && $credentials['status'] == 'on' ? 1 : 2;

            $table->update($credentials);

            return handleResponse('Cập nhật thành công.', 200);
        });
    }

    protected function fastUpdateProduct($request, $modelClass)
    {
        $credentials = $request->validate(
            [
                'name' => 'required|unique:brands,name,' . $request->id,
                'image' => 'nullable|image|mimes:png,jpg,webp',
                'status' => 'nullable'
            ],
            __('request.messages'),
            [
                'name' => 'Tên sản phẩm',
                'image' => 'Ảnh'
            ]
        );

        return transaction(function () use ($request, $credentials, $modelClass) {

            if (!$table = $modelClass::query()->find($request->id)) return errorResponse('Không tìm thấy bản ghi phù hợp', 404);

            if (isset($credentials['image'])) {
                $credentials['image'] = saveImages($request, 'image', 'product');
                deleteImage($table->image);
            }

            $credentials['status'] = isset($credentials['status']) && $credentials['status'] == 'on' ? 1 : 2;

            $table->update($credentials);

            return handleResponse('Cập nhật thành công.', 200);
        });
    }
}
