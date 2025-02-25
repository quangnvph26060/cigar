<?php

namespace App\Http\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
        $id = optional($this->route('attribute'))->id;

        return [
            'name' => 'required|unique:attributes,name,' . $id,
            'slug' => 'nullable|unique:attributes,slug,' . $id,
        ];
    }

    public function messages()
    {
        return __('request.messages');
    }

    public function attributes()
    {
        return [
            'name' => 'Tên thuộc tính',
            'slug' => 'Đường dẫn'
        ];
    }
}
