<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
            // Kiểm tra nếu model là AttributeValue
            if ($validatedData['model'] == 'AttributeValue') {
                foreach ($validatedData['ids'] as $id) {
                    // Gọi hàm để xóa giá trị và cập nhật category_attributes
                    $this->deleteAttributeValue($id);
                }
            } else {
                // Thực hiện xóa các bản ghi dựa trên ID đối với model khác
                $modelClass::whereIn('id', $validatedData['ids'])->delete();
            }

            return response()->json(['message' => 'Xóa thành công!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }


    function removeAttributeValueFromCategories($attributeValueId)
    {
        // Tìm tất cả bản ghi có chứa $attributeValueId
        $categories = DB::table('category_attributes')
            ->where('attribute_value_ids', 'LIKE', "%\"$attributeValueId\"%")
            ->get();



        foreach ($categories as $category) {
            // Chuyển JSON thành mảng
            $ids = json_decode($category->attribute_value_ids, true);

            // Xóa giá trị cần loại bỏ
            $updatedIds = array_values(array_diff($ids, [$attributeValueId]));

            // Nếu mảng rỗng, có thể chọn xóa luôn bản ghi
            if (empty($updatedIds)) {
                DB::table('category_attributes')->where('category_id', $category->category_id)->delete();
            } else {
                // Cập nhật lại mảng JSON sau khi xóa giá trị
                DB::table('category_attributes')
                    ->where('category_id', $category->category_id)
                    ->update(['attribute_value_ids' => json_encode($updatedIds)]);
            }
        }
    }

    function deleteAttributeValue($attributeValueId)
    {
        // Xóa giá trị trong bảng attribute_values
        DB::table('attribute_values')->where('id', (int)$attributeValueId)->delete();

        // Cập nhật category_attributes
        $this->removeAttributeValueFromCategories($attributeValueId);
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
