<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        $id = optional($this->route('slider'))->id;

        return [
            'items' => 'required|array',
            'items.*.image' => ($id ? 'nullable' : 'required') . '|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'items.*.title' => 'nullable|string|max:255',
            'items.*.alt' => 'nullable|string|max:255',
            'items.*.url' => 'nullable|url|max:255',
            'items.*.position' => 'required|integer|min:1',
            'type' => 'required|in:big,small'
        ];
    }


    public function messages()
    {
        return __('request.messages');
    }

    public function attributes()
    {
        return [
            'items.*.title' => 'Tiêu đề',
            'items.*.image' => 'Ảnh',
            'items.*.alt' => 'Văn bản thay thế',
            'items.*.url' => 'URL',
            'items.*.position' => 'Vị trí',
            'items.*.attributes' => 'Thuộc tính',
            'items.*.attributes.*.key' => 'Khóa thuộc tính',
            'items.*.attributes.*.value' => 'Giá trị thuộc tính',
            'type' => 'Loại'
        ];
    }
}
