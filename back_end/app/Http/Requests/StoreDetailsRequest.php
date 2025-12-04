<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetailsRequest extends FormRequest
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
            // 'product_id' => 'nullable|string|exists:products,id',
            'ads_id' => 'required|string|exists:ads,id',
            // 'date' => 'required|date',
            'type' => 'required|string|max:255|in:whatsapp,phone,facebook,instagram,snapchat,linkedin,x,website,visit,menu,google_Map,google_Map_2',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'The type is required.',
            'type.string' => 'The type must be a string.',
            'type.max' => 'The type must not exceed 255 characters.',
            'ads_id.required' => 'The Ads ID is required.',
            'ads_id.string' => 'The Ads ID must be a string.',
            'ads_id.exists' => 'The selected Ads ID does not exist.',
            // 'product_id.required' => 'The Product ID is required.',
            // 'product_id.string' => 'The Product ID must be a string.',
            // 'product_id.exists' => 'The selected Product ID does not exist.',
            'date.required' => 'The date is required.',
            'date.date' => 'The date must be a valid date.',
        ];
    }
}
