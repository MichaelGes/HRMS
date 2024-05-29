<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'zketo_code'=>'required',
            'emp_name'=>'required',
            'branch_id'=>'required',
            'Qualifications_id'=>'required',
            'brith_date'=>'required',
            'emp_national_idenity'=>'required',
            'emp_end_identityIDate'=>'required',
            'emp_identityPlace'=>'required',
            'emp_nationality_id'=>'required',
            'religion_id'=>'required',
            'country_id'=>'required',
            'governorates_id'=>'required',
            'staies_address'=>'required',
            'emp_home_tel'=>'required',
            'is_Disabilities_processes'=>'required',
            'emp_start_date'=>'required',
            'Functiona_status'=>'required',
            'emp_lang_id'=>'required',

            'emp_military_id'=>'required',
            'emp_military_date_from'=>'required_if:emp_military_id,1',
            'emp_military_date_to'=>'required_if:emp_military_id,1',
            'exemption_date'=>'required_if:emp_military_id,2',
            'exemption_reason'=>'required_if:emp_military_id,2',
            'postponement_reason'=>'required_if:emp_military_id,3',

            
            'does_has_Driving_License'=>'required',
            'driving_License_degree'=>'required_if:does_has_Driving_License,1',
            'driving_license_types_id'=>'required_if:does_has_Driving_License,1',
            'Relatives_details'=>'required_if:has_Relatives,1',
            'Disabilities_processes'=>'required_if:is_Disabilities_processes,1',
            'emp_Departments_code'=>'required',
            'emp_jobs_id'=>'required',
            'does_has_ateendance'=>'required',
            'is_has_fixced_shift'=>'required',
            'shift_type_id'=>'required_if:is_has_fixced_shift,1',
            'daily_work_hour'=>'required_if:is_has_fixced_shift,0',
            'emp_sal'=>'required',
            'MotivationType'=>'required',
            'Motivation'=>'required_if:MotivationType,1',
            'isSocialnsurance'=>'required',
            'Socialnsurancecutmonthely'=>'required_if:isSocialnsurance,1',
            'SocialnsuranceNumber'=>'required_if:isSocialnsurance,1',
            'ismedicalinsurance'=>'required',
            'medicalinsurancecutmonthely'=>'required_if:ismedicalinsurance,1',
            'medicalinsuranceNumber'=>'required_if:ismedicalinsurance,1',
            'sal_cach_or_visa'=>'required',
            'is_active_for_Vaccation'=>'required',


        ];
    }
    public function messages(){
        return [
            'zketo_code.required'=>'كود الموظف مطلوب',
            'emp_name.required'=>'اسم المزظف كاملا مطلوب',
            'branch_id.required'=>'يجب تحديد الفرع',
            'Qualifications_id.required'=>'يجب تحديد المؤهل',
            'brith_date.required'=>'يجب ادخال تاريخ ميلاد الموظف',
            'emp_national_idenity.required'=>'يجب ادخال الرقم القومي للموظف',
            'emp_end_identityIDate.required'=>'يجب ادخال تاريخ انتهاء الرقم القومي للموظف',
            'emp_identityPlace.required'=>'يجب ادخال مكان صدور الرقم القومي للموظف',
            'emp_nationality_id.required'=>'يجب اختيار نوع الموظف',
            'religion_id.required'=>'يجب اختيار نوع الموظف',
            'country_id.required'=>'يجب اختيار الدولة',
            'governorates_id.required'=>'يجب اختيار المحافظة',
            'staies_address.required'=>'يجب ادخال عنوان الموظف',
            'emp_home_tel.required'=>'يجب ادخال رقم الهاتف للموظف',
            'exemption_reason.required'=>'يجب ادخال سبب الاعفاء من الخدمة العسكرية',
            'is_Disabilities_processes.required'=>'يجب معرفة اذ كان يمتلك اي اعاقات ام لا',
            'emp_start_date.required'=>'يجب ادخال تاريخ التعين',
            'Functiona_status.required'=>'يجب ادخال حالة الموظف',
            'departements_id.required'=>'يجب اختيار القسم',
            'emp_lang_id.required'=>'يجب معرفة لعة الموظف',
            'emp_military_id.required'=>'هذاالحقل مطلوب',
            'emp_military_date_from.required_if'=>'هذاالحقل مطلوب',
            'emp_military_date_to.required_if'=>'هذاالحقل مطلوب',
            'exemption_date.required_if'=>'هذاالحقل مطلوب',
            'exemption_reason.required_if'=>'هذاالحقل مطلوب',
            'postponement_reason.required_if'=>'هذاالحقل مطلوب',
            'does_has_Driving_License.required'=>'هذا الحقل مطلوب',
            'driving_License_degree.required_if'=>'هذاالحقل مطلوب',
            'driving_license_types.required_if'=>'هذاالحقل مطلوب',
            'Relatives_details'=>'required_if:has_Relatives,1',
            'Disabilities_processes.required_if'=>'هذاالحقل مطلوب',
            'emp_Departments_code.required'=>'هذاالحقل مطلوب',
            'emp_jobs_id.required'=>'هذاالحقل مطلوب',
            'does_has_ateendance.required'=>'هذاالحقل مطلوب',
            'is_has_fixced_shift.required'=>'هذاالحقل مطلوب',
            'shifts_types_id.required_if'=>'هذاالحقل مطلوب',
            'daily_work_hour.required_if'=>'هذاالحقل مطلوب',
            'emp_sal.required'=>'هذاالحقل مطلوب',
            'MotivationType.required'=>'هذاالحقل مطلوب',
            'Motivation.required_if'=>'هذاالحقل مطلوب',
            'isSocialnsurance.required'=>'هذاالحقل مطلوب',
            'Socialnsurancecutmonthely.required_if'=>'هذاالحقل مطلوب',
            'SocialnsuranceNumber.required_if'=>'هذاالحقل مطلوب',
            'ismedicalinsurance.required'=>'هذاالحقل مطلوب',
            'medicalinsurancecutmonthely.required_if'=>'هذاالحقل مطلوب',
            'medicalinsuranceNumber.required_if'=>'هذاالحقل مطلوب',
            'sal_cach_or_visa.required'=>'هذاالحقل مطلوب',
            'is_active_for_Vaccation.required'=>'هذاالحقل مطلوب',
            'shift_type_id.required_if'=>'هذا   الحقل مطلوب',

        ];
    }
}
