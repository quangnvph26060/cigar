<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use League\CommonMark\CommonMarkConverter;

class BulkActionController extends Controller
{

    public function deleteItems(Request $request)
    {
        $validatedData = $request->validate([
            'model' => 'required|string',
            'ids' => 'required|array',
        ]);

        $modelClass = 'App\\Models\\' . $validatedData['model'];

        // Kiểm tra xem class có tồn tại hay không
        if (!class_exists($modelClass)) {
            return response()->json(['message' => 'Model không hợp lệ.'], 400);
        }

        try {
            // Thực hiện xóa các bản ghi dựa trên ID
            $modelClass::whereIn('id', $validatedData['ids'])->delete();

            return response()->json(['message' => 'Xóa thành công!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    public function changeOrder(Request $request)
    {
        $order = $request->input('order');
        $model = 'App\\Models\\' . $request->input('model'); // Tạo namespace model

        if (!class_exists($model)) {
            return response()->json(['error' => 'Model không tồn tại'], 400);
        }

        foreach ($order as $index => $id) {
            $model::where('id', $id)->update(['location' => $index + 1]);
        }

        return response()->json(['status' => 'success']);
    }
}
