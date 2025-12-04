<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDomainRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'unique:domains,name',
            ],
            'url' => [
                'required',
                'string',
                'unique:domains,url',
                'regex:/^([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/'
            ],
        ];
    }

    public function messages(): array
    {
         return [
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'الاسم يجب ان يكون حروف',
            'url.required' => 'الرابط مطلوب',
            'url.string' => 'الرابط يجب ان يكون حروف',
            'url.unique' => 'الرابط موجود من قبل',
            'url.regex' => 'يجب ان يكون  الرابط على شكل رابط صحيح (مثال: example.com)',
            'name.unique' => 'الاسم موجود من قبل',
        ];
    }
}
