<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
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
            'username' => 'required|string|exists:users,username',
            'password' => 'required',

        ];
    }

  public function messages()
{
    return [
        'username.required' => 'اسم المستخدم مطلوب.',
        'username.string' => 'اسم المستخدم يجب أن يكون نصًا.',
        'password.required' => 'كلمة المرور مطلوبة.',
        'username.exists' => 'اسم المستخدم غير موجود.',
    ];
}

}
