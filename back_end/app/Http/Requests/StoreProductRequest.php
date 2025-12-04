<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            // 'category_id' => 'required|string|exists:categories,id',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The  name is required.',
            'name.string' => 'The  name must be a string.',
            'name.max' => 'The  name must not exceed 255 characters.',
            // 'category_id.required' => 'The category ID is required.',
            // 'category_id.string' => 'The category ID must be a string.',
            // 'category_id.exists' => 'The selected category ID does not exist.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg,png,jpg,gif,svg.',
            'image.max' => 'The image must not exceed 2048 kilobytes.',
        ];
    }
}
