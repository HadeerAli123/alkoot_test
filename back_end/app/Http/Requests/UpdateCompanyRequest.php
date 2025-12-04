<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name' => 'required|string',
            'domain' => 'required|exists:domains,id',
            // 'slug' => [
            //     'required',
            //     'string',
            //     'unique:companies,slug,' . $this->route('company'),
            //     'regex:/^[a-zA-Z0-9\-]+$/'
            // ],

        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'name.string' => 'الاسم يجب ان يكون حروف',
            // 'slug.required' => 'المعرف مطلوب',
            // 'slug.string' => 'المعرف يجب ان يكون حروف',
            // 'slug.unique' => 'المعرف موجود من قبل',
            // 'slug.regex' => 'يجب ان يكون المعرف باللغة الانجليزية',
            'domain.required' => 'النطاق مطلوب.',
            'domain.exists' => 'النطاق المختار غير موجود.',
        ];
    }
}
