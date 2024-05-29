@extends('layouts.admin')
@section('title')
غيابات
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
            <div class="card ">
              <div class="card-header">
                <h4> بيانات غيابات الرواتب للموظفين </h4>
              </div>
              <div class="row" style="padding-right: 28px">

              <div class="card-body" id="ajax_responce_serachDiv" style="width: 100%">
                @if(@isset($data) and !@empty($data) and count($data)>0)
                <table id="example2" class="table table-bordered table-hover" style="direction: rtl !important;text-align: center">
                  <thead class="custom_thead ">
                     <th>اسم الشهر</th>
                     <th>تاريخ البداية</th>
                     <th>تاريخ النهاية</th>
                     <th>بداية البصمة</th>
                     <th>انتهاء البصمة</th>
                     <th>عدد الايام</th>
                     <th> حالة الشهر</th>
                  </thead>
                  <tbody>
                     @foreach ( $data as $info )
                     <tr>
                        <td> {{ $info->Month->name }} </td>
                        <td> {{ $info->START_DATE_M }} </td>
                        <td> {{ $info->END_DATE_M }} </td>
                        <td> {{ $info->start_date_for_pasma }} </td>
                        <td> {{ $info->end_date_for_pasma }} </td>
                        <td> {{ $info->number_of_days }} </td>
                         <td> @if($info->is_open==1) مفتوح @elseif ($info->is_open==2)  مغلق و مؤرشف  @else  بانتظار الفتح @endif
                    
                           @if ($info->is_open!=0 )
                           <a href="{{ route('Main_salary_employee_absence.show',$info->id) }}" class="btn btn-primary btn-sm">عرض</a>
                           @endif
                       
                     </td>
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
@endsection
<div class="modal fade" id="load_the_openModel" style="text-align: center" >
   <div class="modal-dialog modal-md">
     <div class="modal-content bg-primary">
       <div class="modal-header">
         <h4 class="modal-title" style="color: white;text-align:center;width: 100%;">فتح الشهر المالي</h4>
         
       </div>
       <div class="modal-body bg-white" id="load_the_openModelBody" style="direction: rtl">
  
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
   
      $(document).on('change','#type_search',function(e){
         ajax_search();
      });
      $(document).on('input','#hour_from_range',function(e){
         ajax_search();
      });
   
      $(document).on('input','#hour_to_range',function(e){
         ajax_search();
      });
   function ajax_search(){
   var type_search=$("#type_search").val();
   var hour_from_range=$("#hour_from_range").val();
   var hour_to_range=$("#hour_to_range").val();
   jQuery.ajax({
   url:'{{ route('SheftsTypes.ajax_search') }}',
   type:'post',
   'dataType':'html',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',type_search:type_search,hour_from_range:hour_from_range,hour_to_range:hour_to_range},
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
   var type_search=$("#type_search").val();
   var hour_from_range=$("#hour_from_range").val();
   var hour_to_range=$("#hour_to_range").val();
   var linkurl=$(this).attr("href");
   jQuery.ajax({
   url:linkurl,
   type:'post',
   'dataType':'html',
   cache:false,
   data:{"_token":'{{ csrf_token() }}',type_search:type_search,hour_from_range:hour_from_range,hour_to_range:hour_to_range},
   success: function(data){
   $("#ajax_responce_serachDiv").html(data);
   },
   error:function(){
   alert("عفوا لقد حدث خطأ ");
   }
   });
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
});
</script>

@endsection
