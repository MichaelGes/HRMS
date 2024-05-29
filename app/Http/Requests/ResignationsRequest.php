<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResignationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name'=>'required',
            'active'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'حقل الاسم مطلوب',
            'active.required'=>'حقل التفعيل مطلوب'
        ]; 
    }
}
