<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OccasionsRequest extends FormRequest
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
            'name'=>'required',
            'from_date'=>'required',
            'to_date'=>'required',
            
            'active'=>'required',

           
        ];
    }
        public function messages(){
            return [
                'name.required'=>'اسم المناسبة مطلوب',
                'from_date.required'=>'تاريخ البداية مطلوب',
                'to_date.required'=>'تاريخ الانتهاء مطلوب',
                'to_date'=>'حقل تاريخ النهاية يجب ان يكون اكبر من او يساوي تاريخ البداية',
                
                'active.required'=>'required',
            ];
        }
    }

