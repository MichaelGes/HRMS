@if(!@empty($finance_cln_periods_data) and !@empty($main_salary_employee_data) and !@empty($data_row))
<div class="modal-body bg-white" id="EditModalBody" style="direction: rtl">
<div class="row">
    
    <div class="col-md-3">
       <div class="form-group">
          <label>بيانات الموظفين</label>
          <select name="employees_code_edit" id="employees_code_edit" class="form-control select2 ">
             <option value="">اختر  الموظف </option>
             @if (@isset($employees) && !@empty($employees))
             @foreach ($employees as $info )
             <option @if($info->employees_code==$data_row['employees_code']) selected @endif value="{{ $info->employees_code }}" data-s="{{ $info->EmployeeData['emp_sal'] }}" data-dp="{{ $info->EmployeeData['day_price'] }}" > {{ $info->EmployeeData['emp_name'] }}  ({{ $info->EmployeeData['zketo_code'] }})</option>
             @endforeach
             @endif
          </select>
       </div>
    </div>

    <div class="col-md-3 related_employees_edit" style="display:none;">
       <div class="form-group">
          <label>راتب الموظف الشهري</label>
          <input readonly class="form-control" type="text" name="emp_sal_edit" id="emp_sal_edit" value="0" >
       </div>
    </div>

    <div class="col-md-3 related_employees_edit " >
       <div class="form-group">
          <label>اجر اليوم الواحد</label>
          <input readonly class="form-control" type="text" name="day_price_edit" id="day_price_edit" value="{{ $data_row['emp_day_price']*1 }}" >
       </div>
    </div>

    <div class="col-md-3">
       <div class="form-group">
          <label>نوع الجزاء</label>
          <select  name="sanctions_type_edit" id="sanctions_type_edit" class="form-control">
          <option @if($data_row['sanctions_type']==1) selected @endif value="1">جزاء ايام</option>
          <option @if($data_row['sanctions_type']==2) selected @endif value="2">جزاء بصمة</option>
          <option @if($data_row['sanctions_type']==3) selected @endif value="3">جزاء تحقيق</option>
       </select>
       </div>
    </div>

    <div class="col-md-3 related_employees_edit ">
       <div class="form-group">
          <label>عدد ايام الجزاء</label>
          <input class="form-control" type="text" name="value_edit" id="value_edit" oninput="this.value=this.value.replace(/[^0-9.]/g,'');" value="{{ $data_row['value']*1 }}" >
       </div>
    </div>

    <div class="col-md-3 related_employees_edit ">
       <div class="form-group">
          <label>اجمالي الجزاء</label>
          <input readonly class="form-control" type="text" name="total_edit" id="total_edit" oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  value="{{ $data_row['total']*1 }}" >
       </div>
    </div>

    <div class="col-md-6 related_employees_edit ">
       <div class="form-group">
          <label>ملاحظات</label>
          <input class="form-control" type="text" name="notes_edit" id="notes_edit" value="{{ $data_row['notes']*1 }}" >
       </div>
    </div>

    <div class="col-md-12 text-center">
       <div class="form-group">
          <button id="do_edit_now"  data-id="{{ $data_row['id'] }}"
            data-main_salary_employee_id="{{$data_row['main_salary_employee_id'] }}"
             type="submit" name="submit"class="btn btn-primary" >تعديل الجزاء</button>
       </div>
    </div>
 </div>
  </div>
@else
<p class="bg-danger text-center"> عفوا لاتوجد بيانات لعرضها</p>
@endif  