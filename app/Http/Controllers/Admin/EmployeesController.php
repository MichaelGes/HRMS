<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\employeee;
use App\Models\Branche;
use App\Models\Departments;
use App\Models\jobs_categorie;
use App\Models\Qualifications;
use App\Models\Religion;
use App\Models\Nationalitie;
use App\Models\Countries;
use App\Models\governorates;
use App\Models\Centers;
use App\Models\blood_groups;
use App\Models\Military_status;
use App\Models\driving_license_type;
use App\Models\Shifts_type;
use App\Models\Employees_files;
use App\Models\Language;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeUpdateRequest;


class EmployeesController extends Controller
{
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_p(new employeee(), array("*"), array("com_code" => $com_code), "id", "DESC", PC);
        $other['branches'] = get_cols_where(new Branche(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['departements'] = get_cols_where(new Departments(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['jobs'] = get_cols_where(new jobs_categorie(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['qualifications'] = get_cols_where(new Qualifications(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['religions'] = get_cols_where(new Religion(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['nationalities'] = get_cols_where(new Nationalitie(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['countires'] = get_cols_where(new Countries(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['governorates'] = get_cols_where(new governorates(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['centers'] = get_cols_where(new centers(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['blood_groups'] = get_cols_where(new blood_groups(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['military_status'] = get_cols_where(new Military_status(), array("id", "name"), array("active" => 1));
        $other['driving_license_types'] = get_cols_where(new driving_license_type(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['shifts_types'] = get_cols_where(new Shifts_type(), array("id", "type", "from_time", "to_time", "total_hour"), array("com_code" => $com_code, "active" => 1));
        $other['languages'] = get_cols_where(new Language(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        return view('admin.Employees.index', ['data' => $data, 'other' => $other]);
    }

    public function create()
    {
        $com_code = auth()->user()->com_code;
        $other['branches'] = get_cols_where(new Branche(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['departements'] = get_cols_where(new Departments(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['jobs'] = get_cols_where(new jobs_categorie(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['qualifications'] = get_cols_where(new Qualifications(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['religions'] = get_cols_where(new Religion(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['nationalities'] = get_cols_where(new Nationalitie(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['countires'] = get_cols_where(new Countries(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['governorates'] = get_cols_where(new governorates(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['centers'] = get_cols_where(new centers(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['blood_groups'] = get_cols_where(new blood_groups(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['military_status'] = get_cols_where(new Military_status(), array("id", "name"), array("active" => 1));
        $other['driving_license_types'] = get_cols_where(new driving_license_type(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['shifts_types'] = get_cols_where(new Shifts_type(), array("id", "type", "from_time", "to_time", "total_hour"), array("com_code" => $com_code, "active" => 1));
        $other['languages'] = get_cols_where(new Language(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        return view("admin.Employees.create", ['other' => $other]);
    }
    public function store(EmployeeRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $CheckExsists = get_cols_where_row(new employeee, array("id"), array("emp_name" => $request->emp_name, 'com_code' => $com_code));
            if (!empty($CheckExsists)) {
                return redirect()->back()->with(['error' => 'عفوا اسم الموظف مسجل من قبل'])->withInput();
            }
            $CheckExsists_zketo_code = get_cols_where_row(new employeee, array("id"), array("zketo_code" => $request->zketo_code, 'com_code' => $com_code));
            if (!empty($CheckExsists_zketo_code)) {
                return redirect()->back()->with(['error' => 'عفوا كود بصمة الموظف مسجل من قبل'])->withInput();
            }
            DB::beginTransaction();
            $last_employee = get_cols_where_row_orderby(new employeee(), array("employees_code"), array('com_code' => $com_code), 'employees_code', 'DESC');
            if (!empty($last_employee)) {
                $dataToInsert['employees_code'] = $last_employee['employees_code'] + 1;
            } else {
                $dataToInsert['employees_code'] = 1;
            }
            $dataToInsert['zketo_code'] = $request->zketo_code;
            $dataToInsert['emp_name'] = $request->emp_name;
            $dataToInsert['emp_gender'] = $request->emp_gender;
            $dataToInsert['branch_id'] = $request->branch_id;
            $dataToInsert['Qualifications_id'] = $request->Qualifications_id;
            $dataToInsert['Qualifications_year'] = $request->Qualifications_year;
            $dataToInsert['graduation_estimate'] = $request->graduation_estimate;
            $dataToInsert['Graduation_specialization'] = $request->Graduation_specialization;
            $dataToInsert['brith_date'] = $request->brith_date;
            $dataToInsert['emp_national_idenity'] = $request->emp_national_idenity;
            $dataToInsert['emp_end_identityIDate'] = $request->emp_end_identityIDate;
            $dataToInsert['emp_identityPlace'] = $request->emp_identityPlace;
            $dataToInsert['blood_group_id'] = $request->blood_group_id;
            $dataToInsert['religion_id'] = $request->religion_id;
            $dataToInsert['emp_lang_id'] = $request->emp_lang_id;
            $dataToInsert['emp_email'] = $request->emp_email;
            $dataToInsert['country_id'] = $request->country_id;
            $dataToInsert['governorate_id'] = $request->governorate_id;
            $dataToInsert['city_id'] = $request->city_id;
            $dataToInsert['emp_home_tel'] = $request->emp_home_tel;
            $dataToInsert['emp_work_tel'] = $request->emp_work_tel;
            $dataToInsert['emp_military_id'] = $request->emp_military_id;
            $dataToInsert['emp_military_date_from'] = $request->emp_military_date_from;
            $dataToInsert['emp_military_date_to'] = $request->emp_military_date_to;
            $dataToInsert['emp_military_wepon'] = $request->emp_military_wepon;
            $dataToInsert['exemption_reason'] = $request->exemption_reason;
            $dataToInsert['exemption_date'] = $request->exemption_date;
            $dataToInsert['postponement_reason'] = $request->postponement_reason;
            $dataToInsert['Date_resignation'] = $request->Date_resignation;
            $dataToInsert['resignation_cause'] = $request->resignation_cause;
            $dataToInsert['does_has_Driving_License'] = $request->does_has_Driving_License;
            $dataToInsert['driving_License_degree'] = $request->driving_License_degree;
            $dataToInsert['driving_license_types_id'] = $request->driving_license_types_id;
            $dataToInsert['has_Relatives'] = $request->has_Relatives;
            $dataToInsert['Relatives_details'] = $request->Relatives_details;
            $dataToInsert['notes'] = $request->notes;
            $dataToInsert['emp_start_date'] = $request->emp_start_date;
            $dataToInsert['Functiona_status'] = $request->Functiona_status;
            $dataToInsert['emp_Departments_code'] = $request->emp_Departments_code;
            $dataToInsert['emp_jobs_id'] = $request->emp_jobs_id;
            $dataToInsert['does_has_ateendance'] = $request->does_has_ateendance;
            $dataToInsert['is_has_fixced_shift'] = $request->is_has_fixced_shift;
            $dataToInsert['shift_type_id'] = $request->shift_type_id;
            $dataToInsert['daily_work_hour'] = $request->daily_work_hour;
            $dataToInsert['emp_sal'] = $request->emp_sal;
            $dataToInsert['MotivationType'] = $request->MotivationType;
            $dataToInsert['Motivation'] = $request->Motivation;
            $dataToInsert['isSocialnsurance'] = $request->isSocialnsurance;
            $dataToInsert['Socialnsurancecutmonthely'] = $request->Socialnsurancecutmonthely;
     //       $dataToInsert['SocialnsuranceNumber'] = $request->SocialnsuranceNumber;
            $dataToInsert['ismedicalinsurance'] = $request->ismedicalinsurance;
            $dataToInsert['medicalinsurancecutmonthely'] = $request->medicalinsurancecutmonthely;
            $dataToUpdate['medicalinsuranceNumber'] = $request->medicalinsuranceNumber;
            $dataToInsert['sal_cach_or_visa'] = $request->sal_cach_or_visa;
            $dataToInsert['is_active_for_Vaccation'] = $request->is_active_for_Vaccation;
            $dataToInsert['urgent_person_details'] = $request->urgent_person_details;
            $dataToInsert['staies_address'] = $request->staies_address;
            $dataToInsert['children_number'] = $request->children_number;
            $dataToInsert['emp_social_status_id'] = $request->emp_social_status_id;
            $dataToInsert['Resignations_id'] = $request->Resignations_id;
            $dataToInsert['bank_number_account'] = $request->bank_number_account;
            $dataToInsert['is_Disabilities_processes'] = $request->is_Disabilities_processes;
            $dataToInsert['Disabilities_processes'] = $request->Disabilities_processes;
            $dataToInsert['emp_nationality_id'] = $request->emp_nationality_id;
            $dataToInsert['emp_cafel'] = $request->emp_cafel;
            $dataToInsert['emp_pasport_no'] = $request->emp_pasport_no;
            $dataToInsert['emp_pasport_from'] = $request->emp_pasport_from;
            $dataToInsert['emp_pasport_exp'] = $request->emp_pasport_exp;
            $dataToInsert['day_price'] = $request->day_price;
            $dataToInsert['Does_have_fixed_allowances'] = $request->Does_have_fixed_allowances;
            $dataToInsert['is_Sensitive_manager_data'] = $request->is_Sensitive_manager_data;
            $dataToUpdate['governorates_id'] = $request->governorates_id;
            if (!empty($request->emp_sal)) {
                $dataToInsert['day_price'] = $request->day_price;
            }
            $dataToInsert['added_by'] = auth()->user()->id;
            $dataToInsert['com_code'] = $com_code;
            //img_upload
            if ($request->has('emp_photo')) {
                $request->validate([
                    'emp_photo' => 'required|mimes:png,jpg,jpeg|max:2000',
                ]);
                $the_file_path = uploadImage('assets/admin/upload', $request->emp_photo);
                $dataToInsert['emp_photo'] =  $the_file_path;
            }
            //cv_upload
            if ($request->has('emp_CV')) {
                $request->validate([
                    'emp_CV' => 'required|mimes:png,jpg,jpeg,doc,docx,pdf|max:2000',
                ]);
                $the_file_path = uploadImage('assets/admin/upload', $request->emp_CV);
                $dataToInsert['emp_CV'] =  $the_file_path;
            }
            insert(new employeee(), $dataToInsert);
            DB::commit();
            return redirect()->route('Employees.index')->with(['success' => 'تم تسجيل بيانات الموظف بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطا ما' . $ex->getMessage()])->withInput();
        }
    }
    public function get_governorates(Request $request)
    {
        if ($request->ajax()) {
            $country_id = $request->country_id;
            $other['governorates'] = get_cols_where(new governorates(), array("id", "name"), array("com_code" => auth()->user()->com_code, 'countries_id' => $country_id));
            return view('admin.Employees.get_governorates', ['other' => $other]);
        }
    }

    public function get_centers(Request $request)
    {
        if ($request->ajax()) {
            $governorates_id = $request->governorates_id;
            $other['centers'] = get_cols_where(new centers(), array("id", "name"), array("com_code" => auth()->user()->com_code, 'governorates_id' => $governorates_id));
            return view('admin.Employees.get_centers', ['other' => $other]);
        }
    }

    public function edit($id)
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new employeee(), array("*"), array("com_code" => $com_code, "id" => $id));
        if (empty($data)) {
            return redirect()->route('Employees.index')->with(['error' => 'قد حدث حطأ اثناء التحديث برجاء الرجوع الي المسؤل']);
        }
        $other['branches'] = get_cols_where(new Branche(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['departements'] = get_cols_where(new Departments(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['jobs'] = get_cols_where(new jobs_categorie(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['qualifications'] = get_cols_where(new Qualifications(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['religions'] = get_cols_where(new Religion(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['nationalities'] = get_cols_where(new Nationalitie(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['countires'] = get_cols_where(new Countries(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['governorates'] = get_cols_where(new governorates(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['centers'] = get_cols_where(new centers(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['blood_groups'] = get_cols_where(new blood_groups(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['military_status'] = get_cols_where(new Military_status(), array("id", "name"), array("active" => 1));
        $other['driving_license_types'] = get_cols_where(new driving_license_type(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        $other['shifts_types'] = get_cols_where(new Shifts_type(), array("id", "type", "from_time", "to_time", "total_hour"), array("com_code" => $com_code, "active" => 1));
        $other['languages'] = get_cols_where(new Language(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
        return view('admin.Employees.edit', ['data' => $data, 'other' => $other]);
    }
    public function update($id, EmployeeUpdateRequest $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new employeee(), array("*"), array("com_code" => $com_code, "id" => $id));
            if (empty($data)) {
                return redirect()->route('Employees.index')->with(['error' => 'قد حدث حطأ اثناء التحديث برجاء الرجوع الي المسؤل']);
            }

            $CheckExsists = employeee::select("id")->where('com_code', '=', $com_code)->where('emp_name', '=', $request->emp_name)->where('id', '!=', $id)->first();
            if (!empty($CheckExsists)) {
                return redirect()->route('Employees.index')->with(['error' => 'عفواً اسم الموظف مسجل من قبل']);
            }

            $CheckExsists_zketo_code = employeee::select("id")->where('com_code', '=', $com_code)->where('zketo_code', '=', $request->zketo_code)->where('id', '!=', $id)->first();
            if (!empty($CheckExsists_zketo_code)) {
                return redirect()->route('Employees.index')->with(['error' => 'عفواً كود بصمة الموظف مسجل من قبل']);
            }
            DB::beginTransaction();
            $dataToUpdate['zketo_code'] = $request->zketo_code;
            $dataToUpdate['emp_name'] = $request->emp_name;
            $dataToUpdate['emp_gender'] = $request->emp_gender;
            $dataToUpdate['branch_id'] = $request->branch_id;
            $dataToUpdate['Qualifications_id'] = $request->Qualifications_id;
            $dataToUpdate['Qualifications_year'] = $request->Qualifications_year;
            $dataToUpdate['graduation_estimate'] = $request->graduation_estimate;
            $dataToUpdate['Graduation_specialization'] = $request->Graduation_specialization;
            $dataToUpdate['brith_date'] = $request->brith_date;
            $dataToUpdate['emp_national_idenity'] = $request->emp_national_idenity;
            $dataToUpdate['emp_end_identityIDate'] = $request->emp_end_identityIDate;
            $dataToUpdate['emp_identityPlace'] = $request->emp_identityPlace;
            $dataToUpdate['blood_group_id'] = $request->blood_group_id;
            $dataToUpdate['religion_id'] = $request->religion_id;
            $dataToUpdate['emp_lang_id'] = $request->emp_lang_id;
            $dataToUpdate['emp_email'] = $request->emp_email;
            $dataToUpdate['country_id'] = $request->country_id;
            $dataToUpdate['governorate_id'] = $request->governorate_id;
            $dataToUpdate['city_id'] = $request->city_id;
            $dataToUpdate['emp_home_tel'] = $request->emp_home_tel;
            $dataToUpdate['emp_work_tel'] = $request->emp_work_tel;
            $dataToUpdate['emp_military_id'] = $request->emp_military_id;
            $dataToUpdate['emp_military_date_from'] = $request->emp_military_date_from;
            $dataToUpdate['emp_military_date_to'] = $request->emp_military_date_to;
            $dataToUpdate['emp_military_wepon'] = $request->emp_military_wepon;
            $dataToUpdate['exemption_reason'] = $request->exemption_reason;
            $dataToUpdate['exemption_date'] = $request->exemption_date;
            $dataToUpdate['postponement_reason'] = $request->postponement_reason;
            $dataToUpdate['Date_resignation'] = $request->Date_resignation;
            $dataToUpdate['resignation_cause'] = $request->resignation_cause;
            $dataToUpdate['does_has_Driving_License'] = $request->does_has_Driving_License;
            $dataToUpdate['driving_License_degree'] = $request->driving_License_degree;
            $dataToUpdate['driving_license_types_id'] = $request->driving_license_types_id;
            $dataToUpdate['has_Relatives'] = $request->has_Relatives;
            $dataToUpdate['Relatives_details'] = $request->Relatives_details;
            $dataToUpdate['notes'] = $request->notes;
            $dataToUpdate['emp_start_date'] = $request->emp_start_date;
            $dataToUpdate['Functiona_status'] = $request->Functiona_status;
            $dataToUpdate['emp_Departments_code'] = $request->emp_Departments_code;
            $dataToUpdate['emp_jobs_id'] = $request->emp_jobs_id;
            $dataToUpdate['does_has_ateendance'] = $request->does_has_ateendance;
            $dataToUpdate['is_has_fixced_shift'] = $request->is_has_fixced_shift;
            $dataToUpdate['shift_type_id'] = $request->shift_type_id;
            $dataToUpdate['daily_work_hour'] = $request->daily_work_hour;
            $dataToUpdate['emp_sal'] = $request->emp_sal;
            $dataToUpdate['MotivationType'] = $request->MotivationType;
            $dataToUpdate['Motivation'] = $request->Motivation;
            $dataToUpdate['isSocialnsurance'] = $request->isSocialnsurance;
            $dataToUpdate['Socialnsurancecutmonthely'] = $request->Socialnsurancecutmonthely;
            $dataToUpdate['SocialnsuranceNumber'] = $request->SocialnsuranceNumber;
            $dataToUpdate['ismedicalinsurance'] = $request->ismedicalinsurance;
            $dataToUpdate['medicalinsurancecutmonthely'] = $request->medicalinsurancecutmonthely;
            $dataToUpdate['medicalinsuranceNumber'] = $request->medicalinsuranceNumber;
            $dataToUpdate['sal_cach_or_visa'] = $request->sal_cach_or_visa;
            $dataToUpdate['is_active_for_Vaccation'] = $request->is_active_for_Vaccation;
            $dataToUpdate['urgent_person_details'] = $request->urgent_person_details;
            $dataToUpdate['staies_address'] = $request->staies_address;
            $dataToUpdate['children_number'] = $request->children_number;
            $dataToUpdate['emp_social_status_id'] = $request->emp_social_status_id;
            $dataToUpdate['Resignations_id'] = $request->Resignations_id;
            $dataToUpdate['bank_number_account'] = $request->bank_number_account;
            $dataToUpdate['is_Disabilities_processes'] = $request->is_Disabilities_processes;
            $dataToUpdate['Disabilities_processes'] = $request->Disabilities_processes;
            $dataToUpdate['emp_nationality_id'] = $request->emp_nationality_id;
            $dataToUpdate['emp_cafel'] = $request->emp_cafel;
            $dataToUpdate['emp_pasport_no'] = $request->emp_pasport_no;
            $dataToUpdate['emp_pasport_from'] = $request->emp_pasport_from;
            $dataToUpdate['emp_pasport_exp'] = $request->emp_pasport_exp;
            $dataToUpdate['emp_Basic_stay_com'] = $request->emp_Basic_stay_com;
            $dataToUpdate['day_price'] = $request->day_price;
            $dataToUpdate['Does_have_fixed_allowances'] = $request->Does_have_fixed_allowances;
            $dataToUpdate['is_Sensitive_manager_data'] = $request->is_Sensitive_manager_data;
            $dataToUpdate['governorates_id'] = $request->governorates_id;
            $dataToUpdate['updated_by'] = auth()->user()->com_code;
            //img_upload
            if ($request->has('emp_photo')) {
                $request->validate([
                    'emp_photo' => 'required|mimes:png,jpg,jpeg|max:2000',
                ]);
                $the_file_path = uploadImage('assets/admin/upload', $request->emp_photo);
                $dataToUpdate['emp_photo'] =  $the_file_path;

                if (file_exists('assets/admin/upload/' . $data['emp_photo']) and !empty($data['emp_photo'])) {
                    unlink('assets/admin/upload/' . $data['emp_photo']);
                }
            }
            //cv_upload
            if ($request->has('emp_CV')) {
                $request->validate([
                    'emp_CV' => 'required|mimes:png,jpg,jpeg,doc,docx,pdf|max:2000',
                ]);
                $the_file_path = uploadImage('assets/admin/upload', $request->emp_CV);
                $dataToUpdate['emp_CV'] =  $the_file_path;

                if (file_exists('assets/admin/upload/' . $data['emp_CV']) and !empty($data['emp_CV'])) {
                    unlink('assets/admin/upload/' . $data['emp_CV']);
                }
            }
            update(new employeee(), $dataToUpdate, array("com_code" => $com_code, "id" => $id));
            DB::commit();
            return redirect()->route('Employees.index')->with(['success' => 'تم تحديث بيانات الموظف بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطا ما' . $ex->getMessage()])->withInput();
        }
    }
    public function destroy($id)
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new employeee(), array("employees_code"), array("com_code" => $com_code, "id" => $id));
        if (empty($data)) {
            return redirect()->route('Employees.index')->with(['error' => 'غير قادر الي الوصول الي البيانات']);
        }
        destroy(new employeee(), array("com_code" => $com_code, "id" => $id));
        return redirect()->route('Employees.index')->with(['success' => 'تم حذف بيانات الموظف بنجاح']);
    }
    public function ajax_search(Request $request)
    {
        if ($request->ajax()) {
            $searchbycode = $request->searchbycode;
            $emp_name = $request->emp_name;
            $branch_id = $request->branch_id;
            $emp_Departments_code = $request->emp_Departments_code;
            $emp_jobs_id = $request->emp_jobs_id;
            $Functiona_status = $request->Functiona_status;
            $sal_cach_or_visa = $request->sal_cach_or_visa;
            $emp_gender = $request->emp_gender;
            $searchbyradio = $request->searchbyradio;
        }

        if ($searchbycode == '') {
            //هنا نعمل شرط دائم التحقق
            $field1 = "id";
            $operator1 = ">";
            $value1 = 0;
        } else {
            if ($searchbyradio == 'zketo_code') {
                $field1 = "zketo_code";
                $operator1 = "=";
                $value1 = $searchbycode;
            } else {
                $field1 = "employees_code";
                $operator1 = "=";
                $value1 = $searchbycode;
            }
        }

        if ($emp_name == '') {
            //هنا نعمل شرط دائم التحقق
            $field2 = "id";
            $operator2 = ">";
            $value2 = 0;
        } else {
            $field2 = "emp_name";
            $operator2 = "like";
            $value2 = "%{$emp_name}%";
        }

        if ($branch_id == 'all') {
            //هنا نعمل شرط دائم التحقق
            $field3 = "id";
            $operator3 = ">";
            $value3 = 0;
        } else {
            $field3 = "branch_id";
            $operator3 = "=";
            $value3 = $branch_id;
        }

        if ($emp_Departments_code == 'all') {
            //هنا نعمل شرط دائم التحقق
            $field4 = "id";
            $operator4 = ">";
            $value4 = 0;
        } else {
            $field4 = "emp_Departments_code";
            $operator4 = "=";
            $value4 = $emp_Departments_code;
        }

        if ($emp_jobs_id == 'all') {
            //هنا نعمل شرط دائم التحقق
            $field5 = "id";
            $operator5 = ">";
            $value5 = 0;
        } else {
            $field5 = "emp_jobs_id";
            $operator5 = "=";
            $value5 = $emp_jobs_id;
        }

        if ($Functiona_status == 'all') {
            //هنا نعمل شرط دائم التحقق
            $field6 = "id";
            $operator6 = ">";
            $value6 = 0;
        } else {
            $field6 = "Functiona_status";
            $operator6 = "=";
            $value6 = $Functiona_status;
        }

        if ($sal_cach_or_visa == 'all') {
            //هنا نعمل شرط دائم التحقق
            $field7 = "id";
            $operator7 = ">";
            $value7 = 0;
        } else {
            $field7 = "sal_cach_or_visa";
            $operator7 = "=";
            $value7 = $sal_cach_or_visa;
        }

        if ($emp_gender == 'all') {
            //هنا نعمل شرط دائم التحقق
            $field8 = "id";
            $operator8 = ">";
            $value8 = 0;
        } else {
            $field8 = "emp_gender";
            $operator8 = "=";
            $value8 = $emp_gender;
        }


        $data = employeee::select("*")->where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->where($field4, $operator4, $value4)->where($field5, $operator5, $value5)->where($field6, $operator6, $value6)->where($field7, $operator7, $value7)->where($field8, $operator8, $value8)->orderby('id', 'DESC')->paginate(PC);
        return view('admin.Employees.ajax_search', ['data' => $data]);
    }


    public function show($id)
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new employeee(), array("*"), array("com_code" => $com_code, "id" => $id));
        if (empty($data)) {
            return redirect()->route('Employees.index')->with(['error' => 'قد حدث حطأ اثناء التحديث برجاء الرجوع الي المسؤل']);
        }

        $other['branches'] = get_cols_where(new Branche(), array("id", "name"), array("com_code" => $com_code, "id" => $data['branch_id']));
        $other['departements'] = get_cols_where(new Departments(), array("id", "name"), array("com_code" => $com_code, "id" => $data['emp_Departments_code']));
        $other['jobs'] = get_cols_where(new jobs_categorie(), array("id", "name"), array("com_code" => $com_code, "id" => $data['emp_jobs_id']));
        $other['qualifications'] = get_cols_where(new Qualifications(), array("id", "name"), array("com_code" => $com_code, "id" => $data['Qualifications_id']));
        $other['religions'] = get_cols_where(new Religion(), array("id", "name"), array("com_code" => $com_code, "id" => $data['religion_id']));
        $other['nationalities'] = get_cols_where(new Nationalitie(), array("id", "name"), array("com_code" => $com_code, "id" => $data['emp_nationality_id']));
        $other['countires'] = get_cols_where(new Countries(), array("id", "name"), array("com_code" => $com_code, "id" => $data['country_id']));
        $other['governorates'] = get_cols_where(new governorates(), array("id", "name"), array("com_code" => $com_code, "id" => $data['governorate_id']));
        $other['centers'] = get_cols_where(new centers(), array("id", "name"), array("com_code" => $com_code, "id" => $data['city_id']));
        $other['blood_groups'] = get_cols_where(new blood_groups(), array("id", "name"), array("com_code" => $com_code, "id" => $data['blood_group_id']));
        $other['military_status'] = get_cols_where(new Military_status(), array("id", "name"), array("id" => $data['emp_military_id']));
        $other['driving_license_types'] = get_cols_where(new driving_license_type(), array("id", "name"), array("com_code" => $com_code, "id" => $data['driving_license_types_id']));
        $other['shifts_types'] = get_cols_where(new Shifts_type(), array("id", "type", "from_time", "to_time", "total_hour"), array("com_code" => $com_code, "id" => $data['shift_type_id ']));
        $other['languages'] = get_cols_where(new Language(), array("id", "name"), array("com_code" => $com_code, "id" => $data['emp_lang_id']));
        $other['employees_files'] = get_cols_where(new Employees_files(), array("*"), array("com_code" => $com_code, "employees_id" => $id));
        return view('admin.Employees.show', ['data' => $data, 'other' => $other]);
    }
    public function download($id, $field_name)
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new employeee(), array($field_name), array("com_code" => $com_code, "id" => $id));
        if (empty($data)) {
            return redirect()->back()->with(['error' => 'قد حدث حطأ اثناء التحديث برجاء الرجوع الي المسؤل']);
        }
        $file_path = "assets/admin/upload/" . $data[$field_name];
        return response()->download($file_path);
    }

    public function add_files($id, request $request)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new employeee(), array("id"), array("com_code" => $com_code, "id" => $id));
            if (empty($data)) {
                return redirect()->route('Employees.index')->with(['error' => 'قد حدث حطأ اثناء التحديث برجاء الرجوع الي المسؤل']);
            }

            $CheckExsists = Employees_files::select("id")->where('com_code', '=', $com_code)->where('name', '=', $request->name)->where('employees_id', '!=', $id)->first();
            if (!empty($CheckExsists)) {
                return redirect()->route('Employees.index')->with(['error' => 'عفواً اسم الملف مسجل من قبل']);
            }

            DB::beginTransaction();
            $dataToinsert['name'] = $request->name;
            $dataToinsert['employees_id'] = $id;
            //img_upload
            if ($request->has('the_file')) {
                $request->validate([
                    'the_file' => 'required|mimes:png,jpg,jpeg|max:2000',
                ]);
                $the_file_path = uploadImage('assets/admin/upload', $request->the_file);
                $dataToinsert['file_path'] =  $the_file_path;
            }
            $dataToinsert['added_by'] = auth()->user()->id;
            $dataToinsert['com_code'] = $com_code;
            //cv_upload
            insert(new Employees_files(), $dataToinsert);
            DB::commit();
            return redirect()->back()->with(['success' => 'تم اضافة بيانات  بنجاح', 'tabfiles' => 'files']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطا ما' . $ex->getMessage()]);
        }
    }
    public function destroy_files($id)
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new Employees_files(), array("id"), array("com_code" => $com_code, "id" => $id));
        if (empty($data)) {
            return redirect()->back()->with(['error' => 'غير قادر الي الوصول الي البيانات']);
        }
        destroy(new Employees_files(), array("com_code" => $com_code, "id" => $id));
        return redirect()->back()->with(['success' => 'تم حذف بيانات الموظف بنجاح', 'tabfiles' => 'files']);
    }

    public function download_files($id)
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new Employees_files(), array("file_path"), array("com_code" => $com_code, "id" => $id));
        if (empty($data)) {
            return redirect()->back()->with(['error' => 'قد حدث حطأ اثناء التحديث برجاء الرجوع الي المسؤل']);
        }
        $file_path = "assets/admin/upload/" . $data['file_path'];
        return response()->download($file_path);
    }
}
