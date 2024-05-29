<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftsTypesRequest extends FormRequest
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
            'type' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'total_hour' => 'required',
            'active' => 'required',

        ];
    }
    public function messages()
    {
        return [
            'type.required' => 'نوع الشيف مطلوب',
            'from_time.required' => 'وقت بداية الشيف مطلوبة',
            'to_time.required' => 'وقت انتهاء الشيف مطلوبة',
            'total_hour.required' => 'اجمالي عدد ساعات الشيفت مطلوية ',
            'active.required' => 'حالة تفعيل الشيفت مطلوبة',


        ];
    }
}
