<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories', 'slug')],
            'description' => 'nullable|string',
        ];
    }

    /**
     * Chuẩn bị dữ liệu trước khi Validation (tạo slug tự động)
     */
    protected function prepareForValidation()
    {
        if ($this->has('name')) {
            $this->merge([
                'slug' => Str::slug($this->name)
            ]);
        }
    }
}
