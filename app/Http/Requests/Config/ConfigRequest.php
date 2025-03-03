<?php

namespace App\Http\Requests\Config;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
        return [
            'website_name' => 'nullable',
            'logo' => 'nullable|image|mimes:png,jpg,webp|max:2048',
            'icon' => 'nullable|image|mimes:png,jpg,webp|max:2048',
            'hotline' => 'nullable',
            'phone_number' => 'nullable',
            'intro_title' => 'nullable',
            'introduction' => 'nullable',
            'address' => 'nullable',
            'email' => 'nullable',
            'copyright' => 'nullable',
            'restriction_message' => 'nullable',
            'adult_only_policy' => 'nullable',

            'title' => 'nullable',
            'seo_title' => 'nullable',
            'seo_description' => 'nullable',
            'seo_keywords' => 'nullable'
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }

    public function attributes(): array
    {
        return [
            'website_name' => 'Tên website',
            'logo' => 'Logo',
            'icon' => 'Biểu tượng (Icon)',
            'hotline' => 'Số hotline',
            'phone_number' => 'Số điện thoại',
            'introduction' => 'Giới thiệu',
            'address' => 'Địa chỉ',
            'email' => 'Email',
            'copyright' => 'Bản quyền',
            'restriction_message' => 'Thông báo giới hạn',
            'adult_only_policy' => 'Chính sách chỉ dành cho người lớn',

            'title' => 'Tiêu đề',
            'seo_title' => 'Tiêu đề SEO',
            'seo_description' => 'Mô tả SEO',
            'seo_keywords' => 'Từ khóa SEO'
        ];
    }
}
