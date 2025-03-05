<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
        $id = optional($this->route('product'))->id;
        return [
            'category_id'           => 'required|exists:categories,id',
            'brand_id'              => 'required|exists:brands,id',
            'code'                  => 'nullable|unique:products,code,' . $id,
            'name'                  => 'nullable|unique:products,name,' . $id,
            'slug'                  => 'nullable|unique:products,slug,' . $id,
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price'                 => 'required|numeric',  // thêm xác nhận cho price là số
            'discount_value'        => 'nullable|numeric|lt:price', // kiểm tra discount_value nhỏ hơn price nếu có giá trị
            'discount_start'        => 'nullable|date',
            'discount_end'          => 'nullable|date|after_or_equal:discount_start', // discount_end phải lớn hơn hoặc bằng discount_start
            'tags'                  => 'nullable',
            'description'           => 'nullable',
            'seo_title'             => 'nullable|max:100',
            'seo_description'       => 'nullable|max:150',
            'seo_keywords'          => 'nullable',
            'position'              => 'nullable|numeric|min:1',
            'status'                => 'required|in:1,2',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }

    public function attributes()
    {
        return [
            'category_id'       => 'Danh mục',
            'brand_id'          => 'Thương hiệu',
            'code'              => 'Mã sản phẩm',
            'name'              => 'Tên sản phẩm',
            'slug'              => 'Đường dẫn',
            'image'             => 'Ảnh sản phẩm',
            'discount_value'    => 'Giá trị giảm giá',
            'discount_start'    => 'Ngày bắt đầu giảm giá',
            'discount_end'      => 'Ngày kết thúc giảm giá',
            'price'            => 'Giá',
            'tags'              => 'Thẻ',
            'description'       => 'Mô tả',
            'seo_title'         => 'Tiêu đề SEO',
            'seo_description'   => 'Mô tả SEO',
            'seo_keywords'      => 'Từ khóa SEO',
            'position'          => 'Vị trí',
            'status'            => 'Trạng thái',
        ];
    }
}
