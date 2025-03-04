<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $id = optional($this->route('post'))->id;
        return [
            'title'           => 'required|string|max:255|unique:posts,title,' . $id,
            'slug'            => 'nullable|string|max:255|unique:posts,slug,' . $id,
            'image'           => ($id ? 'nullable' : 'required') . '|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'content'         => 'required|string',
            'excerpt'         => 'nullable|string|max:500',

            'seo_title'       => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:500',
            'seo_keywords'    => 'nullable',
            'seo_tags'        => 'nullable',

            'status'          => 'required|integer|in:1,2',
            'featured'        => 'nullable',

            'published_at'    => 'nullable|date_format:d-m-Y H:i',
            'removed_at'      => 'nullable|date_format:d-m-Y H:i|after_or_equal:published_at',
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }


    public function attributes(): array
    {
        return [
            'title'             => 'tiêu đề',
            'slug'              => 'đường dẫn',
            'image'             => 'hình ảnh',
            'content'           => 'nội dung',
            'excerpt'           => 'mô tả ngắn',

            'seo_title'         => 'tiêu đề SEO',
            'seo_description'   => 'mô tả SEO',
            'seo_keywords'      => 'từ khóa SEO',
            'seo_tags'          => 'thẻ SEO',

            'status'            => 'trạng thái',
            'featured'          => 'nổi bật',

            'published_at'      => 'ngày xuất bản',
            'removed_at'        => 'ngày gỡ bài',
        ];
    }
}
