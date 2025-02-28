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
            'quantity'              => 'nullable',
            'prices'                => 'required',
            'unit'                  => 'nullable',
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
        ];
    }
}
