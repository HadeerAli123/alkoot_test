<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userRoute = $this->route('user');
        $userId = null;
        if ($userRoute) {
            $userId = is_object($userRoute) ? $userRoute->id : $userRoute;
        }

        return [
            'username' => 'required|string|unique:users,username' . ($userId ? ',' . $userId : ''),
    'password' => 'nullable|string|min:8', // غيرنا required → nullable
            'email' => 'required|email|unique:users,email' . ($userId ? ',' . $userId : ''),
            'name' => 'required|string|max:255',
        ];
    }

    public function messages()
{
    return [
        'username.required' => 'اسم المستخدم مطلوب.',
        'username.string' => 'اسم المستخدم يجب أن يكون نصًا.',
        'username.unique' => 'اسم المستخدم هذا مستخدم بالفعل.',

   
        'password.string' => 'كلمة المرور يجب أن تكون نصًا.',
        'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',

        'email.required' => 'البريد الإلكتروني مطلوب.',
        'email.email' => 'يجب أن يكون البريد الإلكتروني صحيحًا (مثال: xx@xxx.com).',
        'email.unique' => 'هذا البريد الإلكتروني مسجل بالفعل.',

        'name.required' => 'الاسم مطلوب.',
        'name.string' => 'الاسم يجب أن يكون نصًا.',
        'name.max' => 'الاسم لا يجب أن يزيد عن 255 حرفًا.',
    ];
}

}