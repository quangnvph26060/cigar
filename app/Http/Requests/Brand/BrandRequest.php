<?php

namespace App\Http\Requests\Brand;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        $id = optional($this->route('brand'))->id;
        return [
            'name'                  => 'required|unique:brands,name,' . $id,
            'slug'                  => 'nullable|unique:brands,slug,' . $id,
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'name'              => 'Tên danh mục',
            'slug'              => 'Slug danh mục',
            'image'             => 'Hình ảnh',
            'description'       => 'Mô tả',
            'seo_title'         => 'Tiêu đề SEO',
            'seo_description'   => 'Mô tả SEO',
            'seo_keywords'      => 'Từ khóa SEO',
            'position'          => 'Vị trí',
            'status'            => 'Trạng thái',
        ];
    }
}
