<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
 public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'company_id' => 'required|integer|exists:companies,id',
            'description' => 'nullable|string|max:1000',
            'whatsapp_country_code' => 'required_with:whatsapp|in:+966,+20,+971,+965,+964,+962,+963,+968,+973,+974',
            'whatsapp' => 'required_with:whatsapp_country_code|numeric|digits_between:7,15',
            'phone_country_code' => 'required_with:phone|in:+966,+20,+971,+965,+964,+962,+963,+968,+973,+974',
            'phone' => 'required_with:phone_country_code|numeric|digits_between:7,15',
            'instagram' => 'nullable|url|max:255',
            'google_Map' => 'nullable|url|max:255',
            'google_Map_2' => 'nullable|url|max:255',
       
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الفرع مطلوب.',
            'name.max' => 'اسم الفرع لا يزيد عن 255 حرفًا.',
            'company_id.required' => 'معرف الشركة مطلوب.',
            'company_id.exists' => 'الشركة غير موجودة.',
            'description.max' => 'الوصف لا يزيد عن 1000 حرف.',
            'whatsapp_country_code.required_with' => 'كود دولة الواتساب مطلوب إذا أدخلت الرقم.',
            'whatsapp_country_code.in' => 'كود دولة الواتساب غير صالح.',
            'whatsapp.required_with' => 'رقم الواتساب مطلوب إذا اخترت كود الدولة.',
            'whatsapp.numeric' => 'رقم الواتساب يجب أن يكون أرقامًا فقط.',
            'whatsapp.digits_between' => 'رقم الواتساب يجب أن يكون بين 7 و15 رقمًا.',
            'phone_country_code.required_with' => 'كود دولة التواصل مطلوب إذا أدخلت الرقم.',
            'phone_country_code.in' => 'كود دولة التواصل غير صالح.',
            'phone.required_with' => 'رقم التواصل مطلوب إذا اخترت كود الدولة.',
            'phone.numeric' => 'rرقم التواصل يجب أن يكون أرقامًا فقط.',
            'phone.digits_between' => 'رقم التواصل يجب أن يكون بين 7 و15 رقمًا.',
            'instagram.url' => 'رابط إنستجرام غير صالح.',
            'instagram.regex' => 'رابط إنستجرام يجب أن يكون رابطًا صالحًا لموقع Instagram.',
            'google_Map.url' => 'رابط خرائط Google الأول غير صالح.',
            'google_Map.regex' => 'رابط خرائط Google الأول يجب أن يكون رابطًا صالحًا لخرائط Google.',
            'google_Map_2.url' => 'رابط خرائط Google الثاني غير صالح.',
            'google_Map_2.regex' => 'رابط خرائط Google الثاني يجب أن يكون رابطًا صالحًا لخرائط Google.',
     
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validatePhone('whatsapp_country_code', 'whatsapp', $validator);
            $this->validatePhone('phone_country_code', 'phone', $validator);
        });
    }

    protected function validatePhone($codeField, $numberField, $validator)
    {
        $code = $this->input($codeField);
        $number = $this->input($numberField);

        if ($number && $code) {
            $regex = match ($code) {
                '+966' => '/^5\d{8}$/',
                '+20' => '/^1\d{9}$/',
                '+971' => '/^5\d{8}$/',
                '+965' => '/^[569]\d{7}$/',
                '+964' => '/^7\d{9}$/',
                '+962' => '/^7\d{8}$/',
                '+963' => '/^9\d{8}$/',
                '+968' => '/^9\d{7}$/',
                '+973' => '/^3\d{7}$/',
                '+974' => '/^3\d{7}$/',
                default => '/^\d+$/',
            };

            if (!preg_match($regex, $number)) {
                $validator->errors()->add($numberField, 'رقم ' . ($numberField == 'whatsapp' ? 'الواتساب' : 'التواصل') . ' غير صالح لهذا الكود.');
            }
        }
    }
}