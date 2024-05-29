@extends('layouts.admin')
@section('title')
الجزاءات
@endsection
@section('content')

  <!-- Main Content -->
    <section class="section" style="direction: rtl;">
      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card ">
              <div class="card-header" style="text-align: center;width: auto;">
                <h4> بيانات جزاءات الرواتب للشهر المالي  <span style="color:#6777ef "> {{  $finance_cln_periods_data['Month']->name}} </span> لسنة  {{ $finance_cln_periods_data['FINANCE_YR'] }} 
               </h4>
              </div>
              @if($finance_cln_periods_data['is_open']==1)
              <button  class="btn btn-primary" data-toggle='modal' data-target='#AddModal'>اضافة جديد</button>
              @endif
              <br/>
              <form method="POST" action="{{ route('MainSalaryEmployeeSanctions.print_search') }}" target="_blank">
               @csrf
              <input type="hidden" id="the_finance_cln_periods_id" name="the_finance_cln_periods_id" value="{{ $finance_cln_periods_data['id'] }}">
              <div class="row" style="padding-right: 28px">
               
               <div class="col-md-3">
                  <div class="form-group">
                     <label>بحث بالموظفين</label>
                     <select name="employees_code_search" id="employees_code_search" class="form-control select2 ">
                        <option value="all">بحث بالكل</option>
                        @if (@isset($employees_for_search) && !@empty($employees_for_search))
                        @foreach ($employees_for_search as $info )
                        <option value="{{ $info->employees_code }}" > {{ $info->emp_name }} ({{ $info->zketo_code }})</option>
                        @endforeach
                        @endif
                     </select>
                  </div>
               </div>

               <div class="col-md-3">
                  <div class="form-group">
                     <label>بحث بنوع الجزاء</label>
                     <select  name="sanctions_type_search" id="sanctions_type_search" class="form-control select2">
                     <option value="all">بحث بالكل</option>
                     <option value="1">جزاء ايام</option>
                     <option value="2">جزاء بصمة</option>
                     <option value="3">جزاء تحقيق</option>
                  </select>
                  </div>
               </div>

               <div class="col-md-3">
                  <div class="form-group">
                     <label>بحث بنوع الحالة</label>
                     <select  name="is_archived_search" id="is_archived_search" class="form-control select2">
                     <option value="all">بحث بالكل</option>
                     <option value="1">مؤرشف</option>
                     <option value="2">مفتوح</option>
                  </select>
                  </div>
               </div>

               <div class="col-md-3">
                  <div class="form-group">
                  <button type="post" class="btn btn-sm btn-primary custom" style="">طباعة نتيجة البحث</button>
                  </div>
               </div>

              <div class="card-body table-responsive text-center" id="ajax_responce_serachDiv" style="width: 100%">
                @if(@isset($data) and !@empty($data) and count($data)>0)
                <table id="mainTable" class="table table-striped text-center" style="direction: rtl !important;text-align: center">
                  <thead class="custom_thead">  
                     <th>كود الموظف</th>
                     <th>اسم الموظف</th>
                     <th>نوع الجزاء</th>
                     <th>عدد الايام</th>
                     <th>الاجمالي</th>
                     <th>تاريخ الاضافة</th>
                     <th>تاريخ التحديث</th>
                     <th>الحالة</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach ( $data as $info )
                     <tr>
                        <td> {{ $info->zketo_code }} </td>
                        <td> {{ $info->emp_name }}
                           @if (!@empty($info->notes))
                           <br><span style="color: brown">ملاحظة : </span> {{ $info->notes }}
                           @endif
                         </td>
                        <td> @if($info->sanctions_type==1) جزاء ايام @elseif($info->sanctions_type==2) جزاء بصمة  @elseif($info->sanctions_type==3) جزاء تحقيق @else لم يحدد @endif</td>
                        <td> {{ $info->value*1 }} </td>
                        <td> {{ $info->total*1 }} ج.م</td>
                        <td>
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
                         </td>
                         <td> @if($info->is_archived==1) مؤرشف  @else  مفتوح @endif
                           @if ($info->is_open!=0 )
                           <a href="#" class="btn load_the_open_model btn-danger btn-sm">عرض</a>
                           @endif
                     </td>
                  </form>
                     <td> 
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        مأثرات
                      </button>
                      <div class="dropdown-menu text-center">
                        @if($info->is_archived==0)
                        <button class="btn btn-success sm load_edit_this_row"
                        data-id="{{ $info->id }}" 
                        data-main_salary_employee_id="{{ $info->main_salary_employee_id }}" 
                        class="dropdown-item has-icon" >
                        تعديل</button>

                      <button class="btn btn-danger sm delete_this_row" 
                      data-id="{{ $info->id }}"
                      data-main_salary_employee_id="{{ $info->main_salary_employee_id }}"
                      class="dropdown-item has-icon " >   
                        حذف</button>
                        @endif
                      </div>         
                      </td>
                     @endforeach
                  </tbody>
               </table>     
              <br/>
              <div class="col-md-12 text-center">
               {{ $data->links('pagination::bootstrap-5') }}
               </div>
              @else
              <p class="bg-danger text-center"> عفوا لاتوجد بيانات لعرضها</p>
              @endif
           </div>
        </div>
              
     </div>     
   </div>  
</div>
</div>
@endsection
<!--start first model-->
<div class="modal fade" id="AddModal" style="text-align: center" >
   <div class="modal-dialog modal-xl">
     <div class="modal-content bg-primary">
       <div class="modal-header">
         <h4 class="modal-title" style="color: white;text-align:center;width: 100%;">اضافة جزاء جديد</h4>
       </div>
       <div class="modal-body bg-white" id="AddModalBody" style="direction: rtl">
         <div class="row">
         <div class="col-md-3">
            <div class="form-group">
               <label>بيانات الموظفين</label>
               <select name="employees_code_Add" id="employees_code_Add" class="form-control select2 ">
                  <option value="">اختر الموظف </option>
                  @if (@isset($employeees) && !@empty($employeees))
                  @foreach ($employees as $info )
                  <option value="{{ $info->employees_code }}" data-s="{{ $info->EmployeeData['emp_sal'] }}" data-dp="{{ $info->EmployeeData['day_price'] }}" > {{ $info->EmployeeData['emp_name'] }}  ({{ $info->EmployeeData['zketo_code'] }})</option>
                  @endforeach
                  @endif
               </select>
            </div>
         </div>

         <div class="col-md-3 related_employees_add " style="display:none;">
            <div class="form-group">
               <label>راتب الموظف الشهري</label>
               <input readonly class="form-control" type="text" name="emp_sal_add" id="emp_sal_add" value="0" >
            </div>
         </div>

         <div class="col-md-3 related_employees_add " style="display:none;">
            <div class="form-group">
               <label>اجر اليوم الواحد</label>
               <input readonly class="form-control" type="text" name="day_price_add" id="day_price_add" value="0" >
            </div>
         </div>

         <div class="col-md-3">
            <div class="form-group">
               <label>نوع الجزاء</label>
               <select  name="sanctions_type_Add" id="sanctions_type_Add" class="form-control">
               <option value="1">جزاء ايام</option>
               <option value="2">جزاء بصمة</option>
               <option value="3">جزاء تحقيق</option>
            </select>
               @error('MotivationType')
               <span class="text-danger">{{ $message }}</span> 
               @enderror
            </div>
         </div>

         <div class="col-md-3 related_employees_add ">
            <div class="form-group">
               <label>عدد ايام الجزاء</label>
               <input class="form-control" type="text" name="value_Add" id="value_Add" oninput="this.value=this.value.replace(/[^0-9.]/g,'');" value="" >
            </div>
         </div>

         <div class="col-md-3 related_employees_add ">
            <div class="form-group">
               <label>اجمالي الجزاء</label>
               <input readonly class="form-control" type="text" name="total_Add" id="total_Add" oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  value="0" >
            </div>
         </div>

         <div class="col-md-6 related_employees_add ">
            <div class="form-group">
               <label>ملاحظات</label>
               <input class="form-control" type="text" name="notes_Add" id="notes_Add" value="" >
            </div>
         </div>

         <div class="col-md-12 text-center">
            <div class="form-group">
               <button id="do_add_now" type="submit" name="submit"class="btn btn-primary" >اضف الجزاء</button>
            </div>
         </div>

      </div>
       </div>
       <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
      </div>
   </div>
   <!-- /.modal-content -->
 </div>
 <!-- /.modal-dialog -->
</div>
<!-- Large modal -->

<!-- start secand modal -->
<div class="modal fade" id="EditModal" style="text-align: center" >
   <div class="modal-dialog modal-xl">
     <div class="modal-content bg-primary">
       <div class="modal-header">
         <h4 class="modal-title" style="color: white;text-align:center;width: 100%;">تعديل جزاء مسبق</h4>
       </div>
       <div class="modal-body bg-white" id="EditModalBody" style="direction: rtl">
         <div class="row">

        

      </div>
       </div>
       <div class="modal-footer justify-content-between">
         <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
      </div>
   </div>
   <!-- /.modal-content -->
 </div>
 <!-- /.modal-dialog -->
</div>
<!-- Large modal -->


@section('script')
<script>
   $(document).ready(function(){
      $(document).on('change','#employees_code_Add',function(e){
         if($(this).val()==""){
            $(".related_employees_add").hide();
            $("#emp_sal_add").val(0);
            $("#day_price_add").val(0);
         }else{
            var s =$("#employees_code_Add option:selected").data("s");
            var dp =$("#employees_code_Add option:selected").data("dp");
            $("#emp_sal_add").val(s*1);
            $("#day_price_add").val(dp*1);
            $(".related_employees_add").show();
         }
      });

      
      $(document).on('change','#employees_code_edit',function(e){
         if($(this).val()==""){
            $(".related_employees_edit").hide();
            $("#emp_sal_edit").val(0);
            $("#day_price_edit").val(0);
         }else{
            var s =$("#employees_code_edit option:selected").data("s");
            var dp =$("#employees_code_edit option:selected").data("dp");
            $("#emp_sal_add").val(s*1);
            $("#day_price_add").val(dp*1);
            $(".related_employees_add").show();
         }
      });

      $(document).on('click','#do_add_now',function(e){
         var employees_code_Add=$("#employees_code_Add").val();
         if(employees_code_Add==""){
            alert("من فضلك اختر الموظف");
            $("#employees_code_Add").focus();
            return false;
         }
         
         var sanctions_type_Add=$("#sanctions_type_Add").val();
         if(sanctions_type_Add==""){
            alert("من فضلك اختر نوع الجزاء");
            $("#sanctions_type_Add").focus();
            return false;
         }

         var value_Add=$("#value_Add").val();
         if(value_Add==""){
            alert("من فضلك عدد ايام الجزاء");
            $("#value_Add").focus();
            return false;
         }

         var total_Add=$("#total_Add").val();
         if(total_Add==""){
            alert("من فضلك جمالي عدد الجزاء");
            $("#total_Add").focus();
            return false;
         }
         var notes_Add=$("#notes_Add").val();
         var day_price_add=$("#day_price_add").val();


var the_finance_cln_periods_id=$("#the_finance_cln_periods_id").val();
$("#backup_freeze_modal").modal("show");
   jQuery.ajax({
   url:'{{ route('MainSalaryEmployeeSanctions.checkExsistsBefor') }}',
   type:'post',
   'dataType':'json',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',employees_code:employees_code_Add,the_finance_cln_periods_id:the_finance_cln_periods_id},
   success: function(data){
  if(data=='exsists_befor'){
   var res=confirm("يوجد سجل جزاءات سابق مسجل للموظف هل تريد الاستمرار !؟");
   if(res==true){
      var flagRes=true;
   }else{
      var flagRes=false;
   }
  }else{
      var flagRes=true;
  }
if(flagRes==true){
   $("#backup_freeze_modal").modal("show");
   jQuery.ajax({
   url:'{{ route('MainSalaryEmployeeSanctions.store') }}',
   type:'post',
   'dataType':'html',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',employees_code:employees_code_Add,finance_cln_periods_id:the_finance_cln_periods_id,sanctions_type:sanctions_type_Add,value:value_Add,total:total_Add,notes:notes_Add,emp_day_price:day_price_add,notes:notes_Add},
   success: function(data){
   ajax_search();
   setTimeout(function() {
         $("#backup_freeze_modal").modal("hide");
      }, 300);

   },
   error:function(){
      setTimeout(function() {
         $("#backup_freeze_modal").modal("hide");
      }, 300);
   alert("عفوا لقد حدث خطأ ");
   }
   });
}
   },
   error:function(){
   alert("عفوا لقد حدث خطأ ");
   }
   });
      });
      $(document).on('input','#value_Add',function(e){
         var value_Add=$(this).val();
         if(value_Add==""){value_Add=0;}
         var day_price_add=$("#day_price_add").val();
         $("#total_Add").val(value_Add*day_price_add*1);
      });
      $(document).on('input','#value_edit',function(e){
         var value_edit=$(this).val();
         if(value_edit==""){value_edit=0;}
         var day_price_edit=$("#day_price_edit").val();
         $("#total_edit").val(value_edit*day_price_edit*1);
      });
      ///////////////////////    ////////////////////////////////////////
      /////////////////////// SEARCH   //////////////////////////////////////

      $(document).on('change','#employees_code_search',function(e){
         ajax_search();
      });

      $(document).on('change','#sanctions_type_search',function(e){
         ajax_search();
      });

      $(document).on('change','#is_archived_search',function(e){
         ajax_search();
      });
      


   function ajax_search(){
   var employees_code=$("#employees_code_search").val();
   var sanctions_type=$("#sanctions_type_search").val();
   var is_archived=$("#is_archived_search").val();
   var the_finance_cln_periods_id=$("#the_finance_cln_periods_id").val();
   jQuery.ajax({
   url:'{{ route('MainSalaryEmployeeSanctions.ajax_search') }}',
   type:'post',
   'dataType':'html',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',employees_code:employees_code,sanctions_type:sanctions_type,is_archived:is_archived,the_finance_cln_periods_id:the_finance_cln_periods_id},
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
   var employees_code=$("#employees_code_search").val();
   var sanctions_type=$("#sanctions_type_search").val();
   var is_archived=$("#is_archived_search").val();
   var the_finance_cln_periods_id=$("#the_finance_cln_periods_id").val();
   var linkurl=$(this).attr("href");
   jQuery.ajax({
   url:linkurl,
   type:'post',
   'dataType':'html',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',employees_code:employees_code,sanctions_type:sanctions_type,is_archived:is_archived,the_finance_cln_periods_id:the_finance_cln_periods_id},
   success: function(data){
   $("#ajax_responce_serachDiv").html(data);
   },
   error:function(){
   alert("عفوا لقد حدث خطأ ");
   }
   });
   });


   $(document).on('click','.delete_this_row',function(e){
   var res=confirm("هل انت متامد من الحذف ؟");
   if(!res){
      return false;
   }
      var id=$(this).data("id");  
      var the_finance_cln_periods_id=$("#the_finance_cln_periods_id").val();
      var main_salary_employee_id=$(this).data("main_salary_employee_id");
      jQuery.ajax({
   url:'{{ route('MainSalaryEmployeeSanctions.delete_row') }}',
   type:'post',
   'dataType':'json',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',id:id,the_finance_cln_periods_id:the_finance_cln_periods_id,main_salary_employee_id:main_salary_employee_id},
   success: function(data){
      ajax_search();
   },
   error:function(){
   alert("عفوا لقد حدث خطأ ");
   }
   });
   });


   $(document).on('click','.load_edit_this_row',function(e){
      var id=$(this).data("id");  
      var the_finance_cln_periods_id=$("#the_finance_cln_periods_id").val();
      var main_salary_employee_id=$(this).data("main_salary_employee_id");
      jQuery.ajax({
   url:'{{ route('MainSalaryEmployeeSanctions.load_edit_row') }}',
   type:'post',
   'dataType':'html',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',id:id,the_finance_cln_periods_id:the_finance_cln_periods_id,main_salary_employee_id:main_salary_employee_id},
   success: function(data){
   $("#EditModalBody").html(data);
   $("#EditModal").modal("show");
   $('.select2').select2();
   },
   error:function(){
   alert("عفوا لقد حدث خطأ ");
   }
   })
   });
 
   $(document).on('click','.load_the_open_model',function(e){
      var id=$(this).data("id");  
      jQuery.ajax({
   url:'{{ route('MainSalaryRecord.load_open_month') }}',
   type:'post',
   'dataType':'html',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',id:id},
   success: function(data){
   $("#load_the_openModelBody").html(data);
   $("#load_the_openModel").modal("show");
   },
   error:function(){
   alert("عفوا لقد حدث خطأ ");
   }
   });
   });


   $(document).on('click','#do_edit_now',function(e){
      var the_finance_cln_periods_id=$("#the_finance_cln_periods_id").val();
      var main_salary_employee_id=$(this).data("main_salary_employee_id");
      var id=$(this).data("id");
      var employees_code_edit=$("#employees_code_edit").val();
         if(employees_code_edit==""){
            alert("من فضلك اختر الموظف");
            $("#employees_code_edit").focus();
            return false;
         }
         
         var sanctions_type_edit=$("#sanctions_type_edit").val();
         if(sanctions_type_edit==""){
            alert("من فضلك اختر نوع الجزاء");
            $("#sanctions_type_edit").focus();
            return false;
         }

         var value_edit=$("#value_edit").val();
         if(value_edit==""){
            alert("من فضلك عدد ايام الجزاء");
            $("#value_edit").focus();
            return false;
         }

         var total_edit=$("#total_edit").val();
         if(total_edit==""){
            alert("من فضلك جمالي عدد الجزاء");
            $("#total_edit").focus();
            return false;
         }
         var notes_edit=$("#notes_edit").val();
         var day_price_edit=$("#day_price_edit").val();


var the_finance_cln_periods_id=$("#the_finance_cln_periods_id").val();
$("#backup_freeze_modal").modal("show");
   jQuery.ajax({
   url:'{{ route('MainSalaryEmployeeSanctions.do_edit_row') }}',
   type:'post',
   'dataType':'html',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',employees_code:employees_code_edit,the_finance_cln_periods_id:the_finance_cln_periods_id,main_salary_employee_id:main_salary_employee_id,id:id,sanctions_type:sanctions_type_edit,value:value_edit,total:total_edit,notes:notes_edit,emp_day_price:day_price_edit,notes:notes_edit},
   success: function(data){
   ajax_search();
   setTimeout(function() {
         $("#backup_freeze_modal").modal("hide");
      }, 300);

   },
   error:function(){
      setTimeout(function() {
         $("#backup_freeze_modal").modal("hide");
      }, 300);
   alert("عفوا لقد حدث خطأ ");
   }
   });
      });

//////////////////////////////////////////////////////////


});
</script>

@endsection
