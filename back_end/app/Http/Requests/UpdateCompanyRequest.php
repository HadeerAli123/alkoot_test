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
                'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
                'phone' => 'nullable|digits_between:10,15',
    'description' => 'nullable|string|min:10|max:500',

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
                     'logo.image' => 'الملف يجب أن يكون صورة',
    'logo.mimes' => 'صيغة الصورة غير مدعومة',
    'logo.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجا',
            'phone.digits_between' => 'رقم الهاتف يجب أن يكون بين 10 و 15 رقم',
             'description.min' => 'وصف المشروع يجب ألا يقل عن 10 حروف',
    'description.max' => 'وصف المشروع يجب ألا يزيد عن 500 حرف',
 'phone.string' => 'رقم الهاتف لازم يكون نصياً.',
    'phone.max' => 'رقم الهاتف طويل جداً، الحد الأقصى 20 رقم.',

        ];
    }
}
