<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
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
        $id = optional($this->route('category'))->id;

        return [
            'name' => 'required|unique:categories,name,' . $id,
            'slug' => 'nullable|unique:categories,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable',
            'seo_title' => 'nullable|max:100',
            'seo_description' => 'nullable|max:150',
            'seo_keywords' => 'nullable',
            'position' => 'nullable|numeric|min:1',
            'status' => 'required|in:1,2',
            'attribute_id' => 'nullable|array',
            'attribute_id.*' => 'exists:attributes,id',
            'attribute_values' => 'nullable|array',
            'attribute_values.*' => 'required_if:attribute_id.*,.|exists:attribute_values,id',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }

    public function attributes()
    {
        return [
            'name' => 'Tên danh mục',
            'slug' => 'Slug danh mục',
            'image' => 'Hình ảnh',
            'description' => 'Mô tả',
            'seo_title' => 'Tiêu đề SEO',
            'seo_description' => 'Mô tả SEO',
            'seo_keywords' => 'Từ khóa SEO',
            'position' => 'Vị trí',
            'status' => 'Trạng thái',
            'attribute_id' => 'Thuộc tính',
            'attribute_values' => 'Giá trị thuộc tính',
        ];
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     // Get the first validation error
    //     $errors = $validator->errors()->first();

    //     // Return the first error as a response with a 422 status code
    //     throw new HttpResponseException(
    //         response()->json([
    //             'error' => $errors
    //         ], 422)
    //     );
    // }
}
