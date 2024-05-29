@extends('layouts.admin')
@section('title')
عرض بيانات الموظفين
@endsection
@section('content')
<style>
   .del:hover{
     color: red !important;
   }
   .del2:hover{
     color: green !important;
   }
   .card .card-header {
     border-bottom-color: #f9f9f9;
     line-height: 30px;
     -ms-grid-row-align: center;
     align-self: center;
     /* width: 100%; */
     padding: 10px 25px;
     display: flex;
     align-items: center;
 }
 </style>
<!--col-md-6 col-lg-6-->
<div class="col-12">
<div class="card ">
<div class="card-header">
      <h4 style="width:100%;">عرض بيانات الموظف
         <div class="T" style="float: left;">
            <a class="btn btn-primary" href="{{ route('Employees.edit',$data['id']) }}">تعديل</a>
            <a class="btn btn-primary" href="{{ route('Employees.index') }}">سجل الموظفين</a>
         </div>
      </h4>
</div>
<div class="card-body">
<div class="col-12">
</div>
<div class="card-body">
   <ul class="nav nav-tabs" id="myTab2" role="tablist">
         <li class="nav-item">
            <a class="nav-link @if(!Session::has('tabfiles')) active @endif" id="personal_data" data-toggle="tab" href="#home2"
               role="tab" aria-controls="home" aria-selected="true">بيانات شخصية</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" id="jobs_data" data-toggle="tab" href="#profile2"
               role="tab" aria-controls="profile" aria-selected="false">بيانات
               وظفية</a>
         </li>
         <li class="nav-item">
            <a class="nav-link  @if(Session::has('tabfiles')) active @endif" id="addional_data" data-toggle="tab" href="#contact2"
               role="tab" aria-controls="contact" aria-selected="false">بيانات
               اضافية</a>
         </li>
   </ul>

   <div class="tab-content tab-bordered" id="myTab3Content">

   <div class="tab-pane fade @if(!Session::has('tabfiles')) show active @endif" id="home2" role="tabpanel"
      aria-labelledby="personal_data">
      <div class="row">
         <div class="col-md-4">
               <div class="form-group">
                  <label>كود بصمة الموظف</label>
                  <input disabled  autofocus type="text" name="zketo_code" id="zketo_code" oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                     class="form-control" value="{{ $data['zketo_code'] }}">              
               </div>
         </div>

<div class="col-md-4">
      <div class="form-group">
         <label>اسم الموظف كامل  </label>
         <input disabled type="emp_name" name="emp_name" id="emp_name"
            class="form-control" value="{{ $data['emp_name'] }}"
            placeholder="كما هو مدون في البطاقة الشخصية">
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label>النوع </label>
         <select disabled  name="emp_gender" id="emp_gender" class="form-control">
            <option value="">اختر النوع</option>
            <option @if ($data['emp_gender'] == 1) selected @endif
                  value="1">ذكر</option>
            <option @if ($data['emp_gender'] == 2) selected @endif
                  value="2">انثي</option>
         </select>
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label> الفرع التابع له الموظف </label>
         <select disabled  name="branch_id" id="branch_id" class="form-control">
            <option value="">اختر الفرع</option>
            @if (@isset($other['branches']) && !@empty($other['branches']))
                  @foreach ($other['branches'] as $info)
                     <option
                        @if ($data['branch_id'] == $info->id) selected="selected" @endif
                        value="{{ $info->id }}"> {{ $info->name }}
                     </option>
                  @endforeach
            @endif
         </select>
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label> المؤهل الدراسي  </label>
         <select disabled  name="Qualifications_id" id="Qualifications_id  "
            class="form-control select2 ">
            <option value="">اختر المؤهل</option>
            @if (@isset($other['qualifications']) && !@empty($other['qualifications']))
                  @foreach ($other['qualifications'] as $info)
                     <option
                        @if ($data['Qualifications_id'] == $info->id) selected="selected" @endif
                        value="{{ $info->id }}"> {{ $info->name }}
                     </option>
                  @endforeach
            @endif
         </select>
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label>سنة التخرج</label>
         <input disabled  type="date" name="Qualifications_year"
            id="Qualifications_year" class="form-control"
            value="{{ $data['Qualifications_year'] }}">
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label>تقدير التخرج</label>
         <select disabled  disabled  name="graduation_estimate" id="graduation_estimate"
            class="form-control">
            <option @if ($data['graduation_estimate'] == 1) selected @endif
                  value="1">مقبول</option>
            <option @if ( $data['graduation_estimate'] == 2) selected @endif
                  value="2">جيد</option>
            <option @if ( $data['graduation_estimate'] == 3) selected @endif
                  value="3">جيد مرتفع</option>
            <option @if ( $data['graduation_estimate'] == 4) selected @endif
                  value="4">جيد جداً</option>
            <option @if ( $data['graduation_estimate'] == 5) selected @endif
                  value="5">إمتياز </option>
         </select>
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label>تخصص التخرج</label>
         <input disabled  type="text" name="Graduation_specialization"
            id="Graduation_specialization" class="form-control"
            value="{{ $data['Graduation_specialization'] }}">
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label>تاريخ الميلاد </label>
         <input disabled  type="date" name="brith_date" id="brith_date"
            class="form-control" value="{{ $data['brith_date'] }}">
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label>رقم البطاقة الشخصية  </label>
         <input disabled  type="text" name="emp_national_idenity"
            id="emp_national_idenity" class="form-control"
            value="{{ $data['emp_national_idenity'] }}">
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label>تاريخ انتهاء البطاقة الشخصية  </label>
         <input disabled  type="date" name="emp_end_identityIDate"
            id="emp_end_identityIDate" class="form-control"
            value="{{ $data['emp_end_identityIDate']}}">
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label>مكان صدور البطاقة الشخصية </label>
         <input disabled  type="date" name="emp_identityPlace"
            id="emp_identityPlace" class="form-control"
            value="{{ $data['emp_identityPlace'] }}">
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label> فصيلة الدم</label>
         <select disabled  name="blood_group_id" id="blood_group_id"
            class="form-control select2 ">
            <option value="">اختر الفصيلة</option>
            @if (@isset($other['blood_groups']) && !@empty($other['blood_groups']))
                  @foreach ($other['blood_groups'] as $info)
                     <option
                        @if ( $data['blood_group_id'] == $info->id) selected="selected" @endif
                        value="{{ $info->id }}"> {{ $info->name }}
                     </option>
                  @endforeach
            @endif
         </select>
      </div>
</div>

<div class="col-md-4">
      <div class="form-group">
         <label> الجنسية</label>
         <select disabled  name="emp_nationality_id" id="emp_nationality_id"
            class="form-control select2 ">
            <option value="">اختر الجنسية</option>
            @if (@isset($other['nationalities']) && !@empty($other['nationalities']))
                  @foreach ($other['nationalities'] as $info)
                     <option
                        @if (old('emp_nationality_id',$data['emp_nationality_id']) == $info->id) selected="selected" @endif
                        value="{{ $info->id }}"> {{ $info->name }}
                     </option>
                  @endforeach
            @endif
         </select>
      </div>
</div>

         <div class="col-md-4">
               <div class="form-group">
                  <label> الديانة  </label>
                  <select disabled  name="religion_id" id="religion_id"
                     class="form-control select2 ">
                     <option value="">اختر الديانة</option>
                     @if (@isset($other['religions']) && !@empty($other['religions']))
                           @foreach ($other['religions'] as $info)
                              <option
                                 @if (old('religion_id',$data['religion_id']) == $info->id) selected="selected" @endif
                                 value="{{ $info->id }}"> {{ $info->name }}
                              </option>
                           @endforeach
                     @endif
                  </select>
               </div>
         </div>

         <div class="col-md-4">
               <div class="form-group">
                  <label> البريد الالكتروني</label>
                  <input disabled  type="text" name="emp_email" id="emp_email"
                     class="form-control" value="{{ old('emp_email',$data['emp_email']) }}">
               </div>
         </div>

         <div class="col-md-4">
               <div class="form-group">
                  <label>الدول </label>
                  <select disabled  name="country_id" id="country_id"
                     class="form-control select2 ">
                     <option value="">اختر الدولة التابع لها الموظف</option>
                     @if (@isset($other['countires']) && !@empty($other['countires']))
                           @foreach ($other['countires'] as $info)
                              <option
                                 @if (old('country_id',$data['country_id']) == $info->id) selected="selected" @endif
                                 value="{{ $info->id }}"> {{ $info->name }}
                              </option>
                           @endforeach
                     @endif
                  </select>
               </div>
         </div>
         <div class="col-md-4">
               <div class="form-group" id="governorates_Div">
                  <label> المحافظات </label>
                  <select disabled  name="governorates_id" id="governorates_id"
                     class="form-control select2">
                     <option value="">اختر المحافظة التابع لها الموظف</option>
                     @if (@isset($other['governorates']) && !@empty($other['governorates']))
                     @foreach ($other['governorates'] as $info )
                     <option @if(old('governorates_id',$data['governorates_id'])==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }}
                     </option>
                     @endforeach
                     @endif
                  </select>
               </div>
         </div>

         <div class="col-md-4">
               <div class="form-group" id="centers_div">
                  <label> المدينة/المركز </label>
                  <select disabled  name="city_id" id="city_id"
                     class="form-control select2 ">
                     <option value="">اختر المدينة التابع لها الموظف</option>
                     @if (@isset($other['centers']) && !@empty($other['centers']))
                       @foreach ($other['centers'] as $info )
                       <option @if(old('city_id',$data['city_id'])==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }}
                       </option>
                       @endforeach
                       @endif
                  </select>
               </div>
         </div>

         <div class="col-md-8">
               <div class="form-group">
                  <label> عنوان الاقامة الحالي للموظف </label>
                  <input disabled  type="text" name="staies_address" id="staies_address"
                     class="form-control" value="{{ old('staies_address',$data['staies_address']) }}">
               </div>
         </div>

         <div class="col-md-4">
               <div class="form-group">
                  <label> هاتف شخصي</label>
                  <input disabled  type="text" name="emp_home_tel" id="emp_home_tel"
                     class="form-control" value="{{ old('emp_home_tel',$data['emp_home_tel']) }}">
               </div>
         </div>

         <div class="col-md-4">
               <div class="form-group">
                  <label> هاتف العمل</label>
                  <input disabled  type="text" name="emp_work_tel" id="emp_work_tel"
                     class="form-control" value="{{ old('emp_work_tel',$data['emp_work_tel']) }}">
               </div>
         </div>

         <div class="col-md-4">
               <div class="form-group">
                  <label>حالة الخدمة العسكرية </label>
                  <select disabled  name="emp_military_id" id="emp_military_id"
                     class="form-control select2 ">
                     <option value="">اختر الحالة</option>
                     @if (@isset($other['military_status']) && !@empty($other['military_status']))
                           @foreach ($other['military_status'] as $info)
                              <option @if(old('emp_military_id',$data['emp_military_id']) == $info->id) selected="selected" @endif
                                 value="{{ $info->id }}"> {{ $info->name }}
                              </option>
                           @endforeach
                     @endif
                  </select>
               </div>
         </div>

         <div class="col-md-4 related_miltary_1" @if(old('emp_military_id',$data['emp_military_id'])!=1) style="display: none;" @endif>
               <div class="form-group">
                  <label> تاريخ بداية الخدمة العسكرية  </label>
                  <input disabled  type="date" name="emp_military_date_from"
                     id="emp_military_date_from" class="form-control"
                     value="{{ old('emp_military_date_from',$data['emp_military_date_from']) }}">
               </div>
         </div>


         <div class="col-md-4 related_miltary_1" @if(old('emp_military_id',$data['emp_military_id'])!=1) style="display: none;" @endif>
               <div class="form-group">
                  <label> تاريخ نهاية الخدمة العسكرية  </label>
                  <input disabled  type="date" name="emp_military_date_to"
                     id="emp_military_date_to" class="form-control"
                     value="{{ old('emp_military_date_to',$data['emp_military_date_to']) }}">
               </div>
         </div>

         <div class="col-md-4 related_miltary_1" @if(old('emp_military_id',$data['emp_military_id'])!=1) style="display: none;" @endif>
               <div class="form-group">
                  <label> سلاح الخدمة العسكرية </label>
                  <input disabled  type="text" name="emp_military_wepon"
                     id="emp_military_wepon	" class="form-control"
                     value="{{ old('emp_military_wepon',$data['emp_military_wepon']) }}">
               </div>
         </div>

         <div class="col-md-4 related_miltary_2" @if(old('emp_military_id',$data['emp_military_id'])!=2) style="display: none;" @endif>
               <div class="form-group">
                  <label> تاريخ اعفاء الخدمة العسكرية  </label>
                  <input disabled  type="date" name="exemption_date" id="exemption_date"
                     class="form-control" value="{{ old('exemption_date',$data['emp_military_id']) }}">
               </div>
         </div>


         <div class="col-md-4 related_miltary_2" @if(old('emp_military_id',$data['emp_military_id'])!=2) style="display: none;" @endif>
               <div class="form-group">
                  <label> سبب اعفاء الخدمة العسكرية  </label>
                  <input disabled  type="text" name="exemption_reason"
                     id="exemption_reason" class="form-control"
                     value="{{ old('exemption_reason',$data['exemption_reason']) }}">
               </div>
         </div>

         <div class="col-md-4 related_miltary_3" @if(old('emp_military_id',$data['emp_military_id'])!=3) style="display: none;" @endif>
               <div class="form-group">
                  <label> سبب ومدة تأجيل الخدمة العسكرية  </label>
                  <input disabled  type="text" name="postponement_reason"
                     id="postponement_reason" class="form-control"
                     value="{{ old('postponement_reason',$data['postponement_reason']) }}">
               </div>
         </div>

         <div class="col-md-4" >
               <div class="form-group">
                  <label>هل يمتلك رخصة قيادة  </label>
                  <select disabled  name="does_has_Driving_License"
                     id="does_has_Driving_License" class="form-control">
                     <option value=""> اختر الحالة</option>
                     <option @if (old('does_has_Driving_License',$data['does_has_Driving_License']) == 1) selected @endif
                           value="1">نعم </option>
                     <option @if (old('does_has_Driving_License',$data['does_has_Driving_License']) == 0 and old('does_has_Driving_License',$data['does_has_Driving_License']) != '') selected @endif
                           value="2">لا</option>
                  </select>
               </div>

         </div>
         <div class="col-md-4 related_does_has_Driving_License"  @if(old('does_has_Driving_License',$data['does_has_Driving_License'])!=1) style="display: none;" @endif>
            <div class="form-group">
               <label>  رقم رخصة القيادة</label>
               <input disabled  type="text" name="driving_License_degree" id="driving_License_degree" class="form-control" value="{{ old('driving_License_degree',$data['driving_License_degree']) }}">
            </div>
         </div>

         <div class="col-md-4 related_does_has_Driving_License"  @if(old('does_has_Driving_License',$data['does_has_Driving_License'])!=1) style="display: none;" @endif>
            <div class="form-group">
               <label>  نوع رخصة القيادة</label>
               <select disabled  name="driving_license_types_id" id="driving_license_types_id" class="form-control select2 ">
                  <option value="">اختر الحالة </option>
                  @if (@isset($other['driving_license_types']) && !@empty($other['driving_license_types']))
                  @foreach ($other['driving_license_types'] as $info )
                  <option @if(old('driving_license_types_id',$data['driving_license_types_id'])==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
            </div>
         </div>

         <div class="col-md-4">
            <div class="form-group">
               <label>    هل يمتلك  أقارب بالعمل </label>
               <select disabled   name="has_Relatives" id="has_Relatives" class="form-control">
                  <option value="">  اختر الحالة</option>
               <option   @if(old('has_Relatives',$data['has_Relatives'])==1) selected @endif  value="1">نعم </option>
               <option @if(old('has_Relatives',$data['has_Relatives'])==0 and old('has_Relatives')!="" ) selected @endif value="2">لا</option>
            </select>
            </div>
         </div>

         <div class="col-md-12 Related_Relatives_detailsDiv"  @if(old('has_Relatives',$data['has_Relatives'])!=1) style="display: none;" @endif>
            <div class="form-group">
               <label> تفاصيل الاقارب</label>
               <textarea  disabled  type="text" name="Relatives_details" id="Relatives_details" class="form-control" >
                  {{ old('Relatives_details',$data['Relatives_details']) }}
               </textarea>
            </div>
         </div>

         <div class="col-md-4">
            <div class="form-group">
               <label>هل يمتلك اعاقة / عمليات سابقة </label>
               <select disabled   name="is_Disabilities_processes" id="is_Disabilities_processes" class="form-control">
                  <option value="">  اختر الحالة</option>
               <option @if(old('is_Disabilities_processes',$data['is_Disabilities_processes'])==1) selected @endif  value="1">نعم </option>
               <option @if(old('is_Disabilities_processes',$data['is_Disabilities_processes'])==0 and old('is_Disabilities_processes')!="" ) selected @endif value="2">لا</option>
            </select>
            </div>
         </div>

         <div class="col-md-8 Related_is_Disabilities_processesDiv"  @if(old('is_Disabilities_processes',$data['is_Disabilities_processes'])!=1) style="display: none;" @endif>
            <div class="form-group">
               <label> تفاصيل الاعاقة / عمليات سابقة</label>
               <textarea  disabled  type="text" name="Disabilities_processes" id="Disabilities_processes" class="form-control" >
                  {{ old('Disabilities_processes',$data['Disabilities_processes']) }}
               </textarea>
            </div>
         </div>

         <div class="col-md-12 " >
            <div class="form-group">
               <label> ملاحظات علي الموظف </label>
               <textarea  disabled  type="text" name="notes" id="notes" class="form-control" >
                  {{ old('notes',$data['notes']) }}
               </textarea>
            </div>
         </div>
         <!-------->
      </div>
   </div>
         <div class="tab-pane fade" id="profile2" role="tabpanel"
            aria-labelledby="jobs_data">
         <div class="row">
            <div class="col-md-4">
               <div class="form-group">
                  <label>تاريخ التعين </label>
                  <input disabled  type="date" name="emp_start_date" id="emp_start_date"
                     class="form-control" value="{{ old('emp_start_date',$data['emp_start_date']) }}">
               </div>
         </div>

         <div class="col-md-4">
            <div class="form-group">
               <label>الحالة الوظفية </label>
               <select disabled  name="Functiona_status" id="Functiona_status"
                  class="form-control">
                  <option value="">اختر الحالة</option>
                  <option @if (old('Functiona_status',$data['Functiona_status']) == 1) selected @endif
                        value="1">يعمل </option>
                  <option @if (old('Functiona_status',$data['Functiona_status']) == 0 and old('Functiona_status',$data['Functiona_status'])!="") selected @endif
                        value="0">خارج الخدمة</option> 
               </select>
            </div>
      </div>

      <div class="col-md-4">
         <div class="form-group">
            <label> الادارة التابع لها الموظف </label>
            <select disabled  name="emp_Departments_code" id="emp_Departments_code"
               class="form-control select2 ">
               <option value="">اختر الادارة</option>
               @if (@isset($other['departements']) && !@empty($other['departements']))
                     @foreach ($other['departements'] as $info)
                        <option
                           @if (old('emp_Departments_code',$data['emp_Departments_code']) == $info->id) selected="selected" @endif
                           value="{{ $info->id }}"> {{ $info->name }}
                        </option>
                     @endforeach
               @endif
            </select>
         </div>
   </div>

   <div class="col-md-4">
         <div class="form-group">
            <label>الوظيفة </label>
            <select disabled  name="emp_jobs_id" id="emp_jobs_id"
               class="form-control select2 ">
               <option value="">اختر الوظيفة</option>
               @if (@isset($other['jobs']) && !@empty($other['jobs']))
                     @foreach ($other['jobs'] as $info)
                        <option
                           @if (old('emp_jobs_id',$data['emp_jobs_id']) == $info->id) selected="selected" @endif
                           value="{{ $info->id }}"> {{ $info->name }}
                        </option>
                     @endforeach
               @endif
            </select>
         </div>
   </div>

   <div class="col-md-4">
      <div class="form-group">
         <label>هل لة حضور وانصراف </label>
         <select disabled  name="does_has_ateendance" id="does_has_ateendance"
            class="form-control">
            <option value="">اخنر الحالة</option>
            <option @if (old('does_has_ateendance',$data['does_has_ateendance'])==1) selected  @endif
                  value="1">نعم</option>
            <option @if (old('does_has_ateendance',$data['does_has_ateendance'])==0 and old('does_has_ateendance')!="") @endif
                  value="0">لا</option> 
         </select>
      </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label>هل يعمل بشفت ثايت </label>     
      <select disabled  name="is_has_fixced_shift" id="is_has_fixced_shift"
         class="form-control">
         <option value="">اختر الحالة</option>
         <option @if (old('is_has_fixced_shift',$data['is_has_fixced_shift'])==1) selected  @endif value="1">نعم يعمل بشفت ثابت</option>
         <option @if (old('is_has_fixced_shift',$data['is_has_fixced_shift'])==0 and old('is_has_fixced_shift')!="")  @endif value="0">لا يعمل بشفت ثابت</option> 
      </select>
   </div>
</div>

<div class="col-md-4 relatedfixced_shift" @if(old('is_has_fixced_shift',$data['is_has_fixced_shift'])==0 || old('is_has_fixced_shift',$data['is_has_fixced_shift'])=="") style="display: none;" @endif>
   <div class="form-group">
      <label> أنواع الشفتات</label>
      <select disabled  name="shift_type_id" id="shift_type_id" class="form-control select2 ">
         <option value="">اختر الشفت</option> 
         @if (@isset($other['shifts_types']) && !@empty($other['shifts_types']))
         @foreach ($other['shifts_types'] as $info )
         <option @if(old('shift_type_id',$data['shift_type_id'])==$info->id) selected="selected" @endif value="{{ $info->id }}">
            @if($info->type==1) الاولي @elseif ($info->type==2) الثانية @elseif ($info->type==3) الثالثة @else يوم كامل @endif
            من
            @php
            $dt=new DateTime($info->from_time);
            $time=$dt->format("h:i");
            $newDateTime=date("A",strtotime($info->from_time));
            $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
            @endphp
            {{ $time }}
            {{ $newDateTimeType }}  
            الي
            @php
            $dt=new DateTime($info->to_time);
            $time=$dt->format("h:i");
            $newDateTime=date("A",strtotime($info->to_time));
            $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
            @endphp
            {{ $time }}
            {{ $newDateTimeType }}  
         عدد
         {{ $info->total_hour*1  }} ساعات   
         </option>
         @endforeach
         @endif
      </select>
   </div>
</div>

<div class="col-md-4" id="daily_work_hourDiv" @if(old('is_has_fixced_shift',$data['is_has_fixced_shift'])==1 || old('is_has_fixced_shift',$data['is_has_fixced_shift'])=="") style="display: none;" @endif>
   <div class="form-group">
      <label> عدد ساعات العمل اليومي</label>
      <input disabled  type="text" name="daily_work_hour" id="daily_work_hour" oninput="this.value=this.value.replace(/[^0-9.]/g,'');" class="form-control" value="{{ old('daily_work_hour',$data['daily_work_hour']) }}" placeholder="عدد ساعات العمل اذا كان ليس لة شيفت ثابت" >
      @error('daily_work_hour')
      <span class="text-danger">{{ $message }}</span> 
      @enderror
   </div>
</div>

<div class="col-md-4" >
   <div class="form-group">
      <label>راتب الموظف الشهري  </label>
      <input disabled  type="text" name="emp_sal" id="emp_sal" oninput="this.value=this.value.replace(/[^0-9.]/g,'');" class="form-control" value="{{ old('emp_sal',$data['emp_sal']*1) }}" >
   </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label>هل  له حافز  </label>
      <select disabled   name="MotivationType" id="MotivationType" class="form-control">
         <option value="">اختر الحالة</option>
      <option @if(old('MotivationType',$data['MotivationType'])==1) selected @endif  value="1">ثابت</option>
      <option @if(old('MotivationType',$data['MotivationType'])==2) selected @endif  value="2">متغير</option>
      <option @if(old('MotivationType',$data['MotivationType'])==0 and old('MotivationType')!="" ) selected @endif value="0"> لايوجد </option>
   </select>

   </div>
</div>
<div class="col-md-4 " id="MotivationDIV" @if(old('MotivationType',$data['MotivationType'])!=1) style="display: none;" @endif>
   <div class="form-group">
      <label>قيمة الحافز الشهري الثابت</label>
      <input disabled  type="text" name="Motivation" id="Motivation" oninput="this.value=this.value.replace(/[^0-9.]/g,'');" class="form-control" value="{{ old('Motivation',$data['Motivation']*1) }}" >
   </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label>هل له تأمين اجتماعي </label>
      <select disabled   name="isSocialnsurance" id="isSocialnsurance" class="form-control">
         <option value="">اختر الحالة</option>
      <option @if(old('isSocialnsurance',$data['isSocialnsurance'])==1) selected @endif value="1">نعم</option>
      <option @if(old('isSocialnsurance',$data['isSocialnsurance'])==0 and old('isSocialnsurance')!="" ) selected @endif value="0"> لا </option>
   </select>
   </div>
</div>

<div class="col-md-4 relatedisSocialnsurance" @if(old('isSocialnsurance',$data['isSocialnsurance'])!=1) style="display: none;" @endif>
   <div class="form-group">
      <label> رقم التامين الاجتماعي  </label>
      <input disabled  type="text" name="SocialnsuranceNumber" id="SocialnsuranceNumber" class="form-control" value="{{ old('SocialnsuranceNumber',$data['SocialnsuranceNumber']) }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'');" >
   </div>
</div>

<div class="col-md-4 relatedisSocialnsurance"  @if(old('isSocialnsurance',$data['isSocialnsurance'])!=1) style="display: none;" @endif >
   <div class="form-group">
      <label> قيمة التأمين المستقطع شهرياً  </label>
      <input disabled  type="text" name="Socialnsurancecutmonthely" id="Socialnsurancecutmonthely" oninput="this.value=this.value.replace(/[^0-9.]/g,'');" class="form-control" value="{{ old('Socialnsurancecutmonthely',$data['Socialnsurancecutmonthely']*1) }}" >
   </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label>هل  له تأمين طبي  </label>
      <select disabled   name="ismedicalinsurance" id="ismedicalinsurance" class="form-control">
         <option value="">اختر الحالة</option>
      <option @if(old('ismedicalinsurance',$data['ismedicalinsurance'])==1) selected @endif value="1">نعم</option>
      <option @if(old('ismedicalinsurance',$data['ismedicalinsurance'])==0 and old('ismedicalinsurance')!="" ) selected @endif value="0"> لا </option>
   </select>
   </div>
</div>


<div class="col-md-4 relatedismedicalinsurance" @if(old('ismedicalinsurance',$data['ismedicalinsurance'])!=1) style="display: none;" @endif>
   <div class="form-group">
      <label>رقم التامين الطبي للموظف  </label>
      <input disabled  type="text" name="medicalinsuranceNumber" id="medicalinsuranceNumber" class="form-control" value="{{ old('medicalinsuranceNumber',$data['medicalinsuranceNumber']) }}" oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
   </div>
</div>

<div class="col-md-4 relatedismedicalinsurance" @if(old('ismedicalinsurance',$data['ismedicalinsurance'])!=1) style="display: none;" @endif>
   <div class="form-group">
      <label> قيمة التأمين الطبي المستقطع شهرياً</label>
      <input disabled  type="text" name="medicalinsurancecutmonthely" id="medicalinsurancecutmonthely" oninput="this.value=this.value.replace(/[^0-9.]/g,'');" class="form-control" value="{{ old('medicalinsurancecutmonthely',$data['medicalinsurancecutmonthely']*1) }}" >
   </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label> نوع صرف راتب الموظف</label>
      <select disabled   name="sal_cach_or_visa" id="sal_cach_or_visa" class="form-control">
         <option value="">اختر الحالة</option>
      <option   @if(old('sal_cach_or_visa',$data['sal_cach_or_visa'])==1) selected @endif  value="1">كاش</option>
      <option   @if(old('sal_cach_or_visa',$data['sal_cach_or_visa'])==2) selected @endif  value="2">فيزا</option>
   </select>
   </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label> هل له رصيد اجازات سنوي</label>
      <select disabled   name="is_active_for_Vaccation" id="is_active_for_Vaccation" class="form-control">
         <option value="">اختر الحالة</option>
      <option   @if(old('is_active_for_Vaccation',$data['is_active_for_Vaccation'])==1) selected @endif  value="1">نعم</option>
      <option   @if(old('is_active_for_Vaccation',$data['is_active_for_Vaccation'])==0 and old('is_active_for_Vaccation',$data['is_active_for_Vaccation'])!=""  ) selected @endif  value="0">لا</option>
   </select>
   </div>
</div>

<div class="col-md-4 " >
   <div class="form-group">
      <label>  شخص يمكن الرجوع اليه للضرورة  	</label>
      <input disabled  type="text" name="urgent_person_details" id="urgent_person_details" class="form-control" value="{{ old('urgent_person_details') }}" >
   </div>
</div>

 </div>
</div>
<div class="tab-pane fade  @if(Session::has('tabfiles')) show active @endif" id="contact2" role="tabpanel" aria-labelledby="addional_data">         
<div class="row">
<div class="col-md-4 " >
   <div class="form-group">
      <label>  اسم الكفيل 	</label>
      <input disabled  type="text" name="emp_cafel" id="emp_cafel" class="form-control" value="{{ old('emp_cafel',$data['emp_cafel']) }}" >
   </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label>لغة الموظف</label>
      <select disabled  name="emp_lang_id" id="emp_lang_id" class="form-control select2">
         <option value="">اختر الوظيفة</option>
         @if (@isset($other['languages']) && !@empty($other['languages']))
         @foreach ($other['languages'] as $info )
         <option @if(old('emp_lang_id',$data['emp_lang_id'])==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
         @endforeach
         @endif
      </select>
   </div>
</div>

<div class="col-md-4 " >
   <div class="form-group">
      <label>رقم الباسبور ان وجد</label>
      <input disabled  type="text" name="emp_pasport_no" id="emp_pasport_no" class="form-control" value="{{ old('emp_pasport_no',$data['emp_pasport_no']) }}" >
   </div>
</div>

<div class="col-md-4 " >
   <div class="form-group">
      <label>جهة اصدار الباسبور	</label>
      <input disabled  type="text" name="emp_pasport_from" id="emp_pasport_from" class="form-control" value="{{ old('emp_pasport_from',$data['emp_pasport_from']) }}" >
   </div>
</div>
<div class="col-md-4 " >
   <div class="form-group">
      <label>  تاريخ انتهاء الباسبور	</label>
      <input disabled  type="date" name="emp_pasport_exp" id="emp_pasport_exp" class="form-control" value="{{ old('emp_pasport_exp',$data['emp_pasport_exp']) }}" >
      @error('emp_pasport_exp')
      <span class="text-danger">{{ $message }}</span> 
      @enderror
   </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label>عنوان اقامة الموظف في بلده الام</label>
      <input disabled  type="text" name="emp_Basic_stay_com" id="emp_Basic_stay_com" class="form-control" value="{{ old('emp_Basic_stay_com',$data['emp_Basic_stay_com']) }}" >
      @error('emp_Basic_stay_com')
      <span class="text-danger">{{ $message }}</span> 
      @enderror
   </div>
</div>
<div class="col-md-4">
   <div class="form-group">
      <label>الصورة الشخصية</label>
      @if (!@empty($data['emp_photo']))
      <img src="{{ asset('assets/admin/upload').'/'.$data['emp_photo'] }}" style="border-radius: 50% ; width: 80px ; height: 80px ; padding: 10px;" class="rounded_circle" alt="صورة شخصية للموظف"/>
      <a class="btn btn-primary" href="{{ route('Employees.download',['id'=>$data['id'],'field_name'=>'emp_photo']) }}"> <span class="fa fa-download"></span></a>
      @else
         @if($info->emp_gender==1)
         <img src="{{ asset('assets/admin/img/avater_man.png') }}" style="border-radius: 50% ; width: 80px ; height: 80px ; padding: 10px;" class="rounded_circle" alt="صورة شخصية للموظف">
         @else
         <img src="{{ asset('assets/admin/img/avater_woman.png') }}" style="border-radius: 50% ; width: 80px ; height: 80px ; padding: 10px;" class="rounded_circle" alt="صورة شخصية للموظف">
         @endif
      @endif
   </div>
</div>

<div class="col-md-4">
   <div class="form-group">
      <label>السرة الذاتية للموظف</label>
      @if (!@empty($data['emp_CV']))
      <a class="btn btn-primary" href="{{ route('Employees.download',['id'=>$data['id'],'field_name'=>'emp_CV']) }}"> <span class="fa fa-download"></span></a>
      @else
      لم يتم الارفاق
      @endif
   </div>
</div>

</div>
     <div class="card" style="background-color: #dcdcdc">
       <div class="card-header" style="text-align:center;">
         <h6 style="text-align:center;">الملفات المرفقة 
            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-primary" href="#"><i class="fas fa-minus"></i></a></h6>
         <div class="card-header-action">
         </div>
       </div>
       @if(@isset($other['employees_files']) and !@empty($other['employees_files']) and count($other['employees_files'])>0)
<div class="table-responsive text-center bg-white" >
  <table id="mainTable" class="table table-striped bg-white text-center" style="color: black !important">
    <thead>
      <tr>
        <th>الاسم</th> 
        <th>صورة المرفق</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ( $other['employees_files'] as $info )
      <tr>
        <td>{{ $info->name }}</td>        
        <td>
          @if (!@empty($info->file_path))
          <img src="{{ asset('assets/admin/upload').'/'.$info->file_path }}" style="border-radius: 50% ; width: 80px ; height: 80px ; padding: 10px;" class="rounded_circle" alt="صورة شخصية للموظف">
          @else
          لا يوجد
          @endif
        </td>
    
        <td> 
          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          مأثرات
        </button>
        <div class="dropdown-menu text-center">             
          <a class="dropdown-item has-icon are_you_shur del"  href="{{ route('Employees.destroy_files',$info->id) }}"><i class=" fas fa-trash" ></i>حذف</a>
          <a class="dropdown-item has-icon del2" href="{{ route('Employees.download_files',['id'=>$info->id]) }}"><i class=" fas fa-arrow-alt-circle-down" ></i>تحميل</a>
         </div>         
        </td>
    </tr>
    @endforeach
  </tbody>
</table>
<br/>
@else
<p class="bg-danger text-center"> عفوا لاتوجد بيانات لعرضها</p>
@endif
       <div class="collapse show" id="mycard-collapse">
         <div class="card-body">
           <button id="load_add_file_model" data-toggle="modal" data-target="#AddFileModal" class="btn btn-sm btn-primary">ارفاق ملف <i class="fa fa-arrow-up"></i></button>
         </div>
       </div>
     </div>
</div>  
</div>
@endsection
 <!-- Large modal -->
 <div class="modal fade " id="AddFileModal" >
   <div class="modal-dialog modal-xl">
     <div class="modal-content bg-primary">
       <div class="modal-header">
         <h4 class="modal-title" style="color: #ffffff">اضافة مرفقات للموظف</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span></button>
       </div>
       <div class="modal-body bg-white" style="direction:rtl !important">
         <form action="{{ route('Employees.add_files',$data['id']) }}" method="post" enctype="multipart/form-data">
               @csrf
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <label>اسم الملف <span style="color:red;">*</span></label>
                     <input type="text" name="name" id="name"class="form-control" value="" required>
                  </div>
            </div>

            <div class="col-md-4">
               <div class="form-group">
                  <label>اختر الملف</label>
                  <input type="file" name="the_file" id="the_file" class="form-control" value="" required>
               </div>
            </div>

            <div class="col-md-12 text-center">
               <div class="form-group">
                  <button type="submit" name="submit"class="btn btn-primary">اضف الملف</button>
               </div>
            </div>

         </form>
       </div>
       <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
       </div>
     </div>
   </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
 </div>
 <!-- Large modal -->
