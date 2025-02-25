<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;

class AttributeValueRequest extends FormRequest
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
        $id = request()->id;

        return [
            'value' => 'required|unique:attribute_values,value,' . $id,
            'slug' => 'nullable|unique:attribute_values,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable',
            'seo_title'             => 'nullable|max:100',
            'seo_description'       => 'nullable|max:150',
            'seo_keywords'          => 'nullable',
            'status' => 'required|in:1,2'
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }

    public function attributes()
    {
        return [
            'value' => 'Giá trị',
            'slug' => 'Slug',
            'image' => 'Ảnh đại diện',
            'description' => 'Mô tả',
            'seo_title' => 'Tiêu đề SEO',
            'seo_description' => 'Mô tả SEO',
            'seo_keywords' => 'Từ khóa SEO',
            'status' => 'Trạng thái',
        ];
    }
}
