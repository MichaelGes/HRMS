@extends('layouts.admin')
@section('title')
بيانات الموظفين
@endsection
@section('content')
<style>
  .del:hover{
    color: red !important;
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
<!-- Main Content -->

<section class="section " style="direction: rtl;">
<div class="section-body">
<div class="row">
<div class="col-12">
<div class="card">

<a href="{{ route('Employees.create') }}" class="btn btn-primary">اضافة جديد</a>
<div class="card-header">
  <h4>بيانات الموظفين</h4>  
</div>
<div class="row" style="padding-left:28px;padding-right:28px">
  <div class="col-md-3">
    <div class="form-group">
      <label>
        <input checked name="searchbyradiocode" type="radio" value="zketo_code" > كود البصمة
        <input name="searchbyradiocode" type="radio" value="employees_code"> كود النظام 
      </label>
      <input autofocus type="text" name="searchbycode" id="searchbycode" oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
          class="form-control" value="">
    </div>
  </div>

  <div class="col-md-3">
  <div class="form-group">
    <label>اسم الموظف</label>
    <input type="emp_name_search" name="emp_name_search" id="emp_name_search"
        class="form-control" value="">
  </div>
</div>

<div class="col-md-3">
<div class="form-group"  >
    <label>الفرع</label>
    <select name="branch_id_search" id="branch_id_search" class="form-control select2"style="width: 100%">
      <option value="all">اختر الفرع</option>
      @if (@isset($other['branches']) && !@empty($other['branches']))
            @foreach ($other['branches'] as $info)
                <option value="{{ $info->id }}"> {{ $info->name }} </option>
            @endforeach
      @endif
    </select>       
</div>
</div>

<div class="col-md-3">
<div class="form-group">
  <label>بحث بالادارة</label>
  <select name="emp_Departments_code_search" id="emp_Departments_code_search"
    class="form-control select2" style="width: 100%">
    <option value="all">اختر الادارة</option>
    @if (@isset($other['departements']) && !@empty($other['departements']))
          @foreach ($other['departements'] as $info)
              <option value="{{ $info->id }}"> {{ $info->name }} </option>
          @endforeach
    @endif
  </select>
</div>   
</div>  

<div class="col-md-3">
  <div class="form-group">
     <label>الوظيفة</label>
     <select name="emp_jobs_id_search" id="emp_jobs_id_search"
        class="form-control select2 ">
        <option value="all">اختر الوظيفة</option>
        @if (@isset($other['jobs']) && !@empty($other['jobs']))
              @foreach ($other['jobs'] as $info)
                 <option value="{{ $info->id }}"> {{ $info->name }} </option>
              @endforeach
        @endif
     </select>
  </div>
</div>

<div class="col-md-3">
  <div class="form-group">
     <label> يحث بالحالةالوظفية</label>
     <select name="Functiona_status_search" id="Functiona_status_search"
        class="form-control select2">
        <option value="all">اختر الحالة</option>
        <option value="1">يعمل </option>
        <option value="0">خارج الخدمة</option> 
     </select>
  </div>
</div>

<div class="col-md-3">
  <div class="form-group">
     <label>بحث بنوع صرف راتب الموظف</label>
     <select  name="sal_cach_or_visa_search" id="sal_cach_or_visa_search" class="form-control select2">
     <option value="all">اختر الحالة</option>
     <option value="1">كاش</option>
     <option value="2">فيزا</option>
  </select>
  </div>
</div>

<div class="col-md-3">
  <div class="form-group">
     <label>النوع</label>
     <select name="emp_gender_search" id="emp_gender_search" class="form-control select2">
        <option value="all">اختر النوع</option>
        <option value="1">ذكر</option>
        <option value="2">انثي</option>
     </select>
  </div>
</div>
</div>
     
<div class="card-body" id="ajax_responce_serachDiv">
@if(@isset($data) and !@empty($data) and count($data)>0)
<div class="table-responsive text-center">
  <table id="mainTable" class="table table-striped text-center">
    <thead>
      <tr>
        <th>كود</th> 
        <th>اسم الموظف</th>
        <th>الفرع التابع لة</th>     
        <th>القسم</th>
        <th>الوظيفة</th>
        <th>الحالة الوظفية</th>
        <th>صورة شخصية</th>
      <!--  <th>الاضافة بواسطة</th>
        <th>التحديث بواسطة</th>-->
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ( $data as $info )
      <tr>
        <td>{{ $info->zketo_code }}</td>    
        <td>{{ $info->emp_name }}</td> 
        <td>
          @if(!@empty($info->Branch))
          {{ $info->Branch->name }}
          @endif
        </td>   
        <td>
          @if(!@empty($info->Departments))
          {{ $info->Departments->name }}
          @endif
        </td> 
        <td>
          @if(!@empty($info->jobs))
          {{ $info->jobs->name }}
          @endif
        </td> 
        <td>
          @if($info->Functiona_status==1) يعمل @else لا يعمل @endif 
        </td>
        <td>
          @if (!@empty($info->emp_photo))
          <img src="{{ asset('assets/admin/upload').'/'.$info->emp_photo }}" style="border-radius: 50% ; width: 80px ; height: 80px ; padding: 10px;" class="rounded_circle" alt="صورة شخصية للموظف">
          @else
            @if($info->emp_gender==1)
            <img src="{{ asset('assets/admin/img/avater_man.png') }}" style="border-radius: 50% ; width: 80px ; height: 80px ; padding: 10px;" class="rounded_circle" alt="صورة شخصية للموظف">
            @else
            <img src="{{ asset('assets/admin/img/avater_woman.png') }}" style="border-radius: 50% ; width: 80px ; height: 80px ; padding: 10px;" class="rounded_circle" alt="صورة شخصية للموظف">
            @endif
          @endif
        </td>
      <!--    <td>
          @php    
            $dt=new DateTime($info->created_at);
            $date=$dt->format("Y-m-d");
            $time=$dt->format("h:i");
            $newDateTime=date("a",strtotime($info->created_at));
            $newDateTimeType=(($newDateTime=='AM')?'صباحاً':'مساءاً');
          @endphp
          {{ $date }}<br>
          {{ $time }}
          {{ $newDateTimeType }}<br>    
          {{ $info->added->name }} 
        </td>
        
      <td>
          @if($info->updated_by>0)
          @php    
          $dt=new DateTime($info->updated_at);
          $date=$dt->format("Y-m-d");
          $time=$dt->format("h:i");
          $newDateTime=date("a",strtotime($info->updated_at));
          $newDateTimeType=(($newDateTime=='AM')?'صباحاً':'مساءاً');
        @endphp
        {{ $date }}<br>
        {{ $time }}
        {{ $newDateTimeType }}<br>    
        {{ $info->updatedby->name }} 
        @else
        لايوجد
        @endif
        </td>-->
        <td> 
          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          مأثرات
        </button>
        <div class="dropdown-menu text-center">             
          <a class="dropdown-item has-icon" href="{{ route('Employees.edit',$info->id) }}"><i class="far fa-edit"></i> تعديل</a>
          <a class="dropdown-item has-icon are_you_shur del" href="{{ route('Employees.destroy',$info->id) }}"><i class=" fas fa-trash" ></i>حذف</a>
          <a class="dropdown-item has-icon" href="{{ route('Employees.show',$info->id) }}"><i class="fas fa-eye"></i>عرض المزيد</a>
        </div>         
        </td>
    </tr>
    @endforeach
  </tbody>
</table>
<br/>
<div class="col-md-12">
{{ $data->links('pagination::bootstrap-5') }}
</div>
@else
<p class="bg-danger text-center"> عفوا لاتوجد بيانات لعرضها</p>
@endif
</div>
</div>
</div>     
</section>
@endsection
@section('script')
<script>
    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap5'
    });

    $(document).ready(function(){
   
   $(document).on('input','#searchbycode',function(e){
      ajax_search();
   });
   $(document).on('input','#emp_name_search',function(e){
      ajax_search();
   });

   $(document).on('change','#branch_id_search',function(e){
      ajax_search();
   });

   $(document).on('change','#emp_Departments_code_search',function(e){
      ajax_search();
   });

   $(document).on('change','#emp_jobs_id_search',function(e){
      ajax_search();
   });

   $(document).on('change','#Functiona_status_search',function(e){
      ajax_search();
   });  

   $(document).on('change','#sal_cach_or_visa_search',function(e){
      ajax_search();
   });

   $(document).on('change','#emp_gender_search',function(e){
      ajax_search();
   });

   $('input[type=radio][name=searchbyradiocode]').change(function(){
    ajax_search();
   });
   

function ajax_search(){
var searchbycode=$("#searchbycode").val();
var emp_name=$("#emp_name_search").val();
var branch_id=$("#branch_id_search").val();
var emp_Departments_code=$("#emp_Departments_code_search").val();
var emp_jobs_id=$("#emp_jobs_id_search").val();
var Functiona_status=$("#Functiona_status_search").val();
var sal_cach_or_visa=$("#sal_cach_or_visa_search").val();
var emp_gender=$("#emp_gender_search").val();
var searchbyradio = $("input[type=radio][name=searchbyradiocode]:checked").val();

jQuery.ajax({
url:'{{ route('Employees.ajax_search') }}',
type:'post',
'dataType':'html',
cache:false,
data:{"_token":'{{ csrf_token() }}',searchbycode:searchbycode,emp_name:emp_name,branch_id:branch_id,
emp_Departments_code:emp_Departments_code,emp_jobs_id:emp_jobs_id,Functiona_status:Functiona_status
,sal_cach_or_visa:sal_cach_or_visa,emp_gender:emp_gender,searchbyradio:searchbyradio},
success: function(data){
$("#ajax_responce_serachDiv").html(data);
},
error:function(){
alert("عفوا لقد حدث خطأ ");
}

});
}
$(document).on('click','#ajax_pagination_in_search a',function(e){
e.preventDefault();
var searchbycode=$("#searchbycode").val();
var emp_name=$("#emp_name_search").val();
var branch_id=$("#branch_id_search").val();
var emp_Departments_code=$("#emp_Departments_code_search").val();
var emp_jobs_id=$("#emp_jobs_id_search").val();
var Functiona_status=$("#Functiona_status_search").val();
var sal_cach_or_visa=$("#sal_cach_or_visa_search").val();
var emp_gender=$("#emp_gender_search").val();
var searchbyradio=$("input[type=radio][name=searchbyradiocode]:checked").val();

var linkurl=$(this).attr("href");
jQuery.ajax({
url:linkurl,
type:'post',
'dataType':'html',
cache:false,
data:{"_token":'{{ csrf_token() }}',searchbycode:searchbycode,emp_name:emp_name,branch_id:branch_id,
emp_Departments_code:emp_Departments_code,emp_jobs_id:emp_jobs_id,Functiona_status:Functiona_status
,sal_cach_or_visa:sal_cach_or_visa,emp_gender:emp_gender,searchbyradio:searchbyradio},success: function(data){
$("#ajax_responce_serachDiv").html(data);
},
error:function(){
alert("عفوا لقد حدث خطأ ");
}
});
});
});


</script>
@endsection

