<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdsRequest extends FormRequest
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
            // 'company_id' => 'required|string|exists:companies,id',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,mp4,mov,avi,webm,mkv,pdf|max:20480',
            function ($attribute, $value, $fail) {
                $maxVideoSizeKB = 51200; // 50 MB
                $maxOtherSizeKB = 2048;  // 2 MB

                $extension = strtolower($value->getClientOriginalExtension());

                if (in_array($extension, ['mp4', 'mov', 'avi', 'webm', 'mkv']) && $value->getSize() / 1024 > $maxVideoSizeKB) {
                    $fail('The video may not be greater than 50 MB.');
                }

                if (in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'svg', 'pdf']) && $value->getSize() / 1024 > $maxOtherSizeKB) {
                    $fail('The file may not be greater than 2 MB.');
                }
            },
            // 'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount_per_day' => 'required|numeric|min:0',
            // 'product_ids' => 'required|array',
            // 'product_ids.*' => 'exists:products,id',
        ];
    }

     public function messages()
    {
        return [
             'name.required' => 'الاسم مطلوب.',
            'name.string' => 'الاسم يجب ان يكون حروف',
            // 'image.image' => 'الملف المرفوع يجب ان يكون صورة',
            // 'image.mimes' => 'The image must be a file of type: jpeg,png,jpg,gif,svg.',
            'image.max' => 'الصورة يجب الا تتعدى 2048 كيلوبايت.',
          
            'start_date.required' => 'تاريخ البداية مطلوب',
            'start_date.date' => 'التاريخ غير صحيح',
            'end_date.required' => 'تاريخ النهاية مطلوب',
            'end_date.date' => 'التاريخ غير صحيح',
            'end_date.after_or_equal' => 'يجب ان يكون تاريخ النهاية اكبر من تاريخ البداية',
            'amount_per_day.required' => 'قيمة اعلان لليوم مطلوبة',
            // 'product_ids.array' => 'The product IDs must be an array.',
            // 'product_ids.*.exists' => 'The selected product ID does not exist.',
        ];
      
    }
}
