<?php

namespace App\Http\Requests\Variation;

use Illuminate\Foundation\Http\FormRequest;

class VariationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = optional($this->route('variation'))->id;

        return [
            'product_id'            => 'required|exists:products,id',
            'name'                  => 'required|unique:variations,name,' . $id,
            'slug'                  => 'nullable|unique:variations,slug,' . $id,
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating'                => 'nullable',
            'quality'               => 'nullable',
            'radius'                => 'nullable',
            'length'                => 'nullable',
            'strength'              => 'nullable',
            'quantity'              => 'nullable',
            'unit'                  => 'nullable',
            'tags'                  => 'nullable',
            'description'           => 'nullable',
            'seo_title'             => 'nullable|max:100',
            'seo_description'       => 'nullable|max:150',
            'seo_keywords'          => 'nullable',
            'position'              => 'nullable|numeric|min:1',
            'status'                => 'required|in:1,2',

            'options'                   => 'required|array|min:1',
            'options.*.price'            => 'required|numeric|min:0',
            'options.*.discount_value'   => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1]; // Lấy index của options.*
                    $price = request()->input("options.$index.price"); // Lấy giá trị price tương ứng

                    if ($value >= $price) {
                        $fail("Giá trị giảm giá phải nhỏ hơn giá gốc.");
                    }
                }
            ],
            'options.*.discount_start'   => 'nullable|date|after_or_equal:today',
            'options.*.discount_end'     => 'nullable|date|after_or_equal:options.*.discount_start',
            'options.*.unit'             => 'required|string|max:50',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }

    public function attributes()
    {
        return [
            'product_id'        => 'Sản phẩm',
            'name'              => 'Tên biến thể',
            'slug'              => 'Slug biến thể',
            'image'             => 'Hình ảnh',
            'rating'            => 'Đánh giá',
            'quality'           => 'Chất lượng',
            'radius'            => 'Bán kính',
            'length'            => 'Chiều dài',
            'quantity'          => 'Số lượng',
            'prices'            => 'Giá',
            'unit'              => 'Đơn vị',
            'tags'              => 'Tags',
            'description'       => 'Mô tả',
            'seo_title'         => 'Tiêu đề SEO',
            'seo_description'   => 'Mô tả SEO',
            'seo_keywords'      => 'Từ khóa SEO',
            'position'          => 'Vị trí',
            'status'            => 'Trạng thái',

            'options'                   => 'Danh sách giá',
            'options.*.price'            => 'Giá',
            'options.*.discount_value'   => 'Giá trị giảm giá',
            'options.*.discount_start'   => 'Ngày bắt đầu giảm giá',
            'options.*.discount_end'     => 'Ngày kết thúc giảm giá',
            'options.*.unit'             => 'Đơn vị',
        ];
    }
}
