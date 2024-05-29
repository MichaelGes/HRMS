@extends('layouts.admin')
@section('title')
انواع الشفتات
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
              <a href="{{ route('SheftsTypes.Create') }}" class="btn btn-primary">اضافة جديد</a>
              <div class="card-header">
                <h4>انواع الشيفتات الموظفين</h4>
              </div>
              <div class="row" style="padding-right: 28px">
              <div class="col-md-3">
                <div class="form-group">
                   <label>بحث</label>
                   <select name="type_search" id="type_search" class="form-control">
                      <option selected value="all">بحث بالكل</option>
                      <option  value="1">الاولي</option>
                      <option  value="2">الثانية</option>
                      <option  value="3">الثالثة</option>
                   </select>
                </div>
             </div>

             <div class="col-md-3">
              <div class="form-group">
                 <label>من عدد الساعات</label>
                 <input type="text" name="hour_from_range" id="hour_from_range" class="form-control" value=""  oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  >
              </div>
           </div>

           <div class="col-md-3">
            <div class="form-group">
               <label>الي عدد الساعات</label>
               <input type="text" name="hour_to_range" id="hour_to_range" class="form-control" value=""  oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  >
            </div>
         </div>
        </div>
              <div class="card-body" id="ajax_responce_serachDiv">
                @if(@isset($data) and !@empty($data) and count($data)>0)
                <div class="table-responsive text-center">
                  <table id="mainTable " class="table table-striped text-center">
                    <thead>
                      <tr>
                        <th>نوع الشيفت</th>
                        <th>يبدأ من الساعة</th>
                        <th>ينتهي الساعة</th>
                        <th>عددالساعات</th>  
                        <th>حالة التفعيل</th>
                        <th>الاضافة بواسطة</th>
                        <th>التحديث بواسطة</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ( $data as $info )
                      <tr>
                       
                        <td>  @if($info->type==1)  الاولي  @elseif($info->type==2)  الثانية @elseif($info->type==3) الثالثة @else يوم كامل   @endif </td>
                        <td> {{ $info->from_time }} </td>
                        <td> {{ $info->to_time }} </td>
                        <td> {{ $info->total_hour*1 }} </td>
                        <td @if ($info->active==1) class="bg-success" @else class="bg-danger" @endif> @if ($info->active==1) مفعل @else معطل @endif </td>
                        <td>
                          @php    
                            $dt=new DateTime($info->created_at);
                            $date=$dt->format("Y-m-d");
                            $time=$dt->format("h:i");
                            $newDateTime=date("A",strtotime($time));
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
                          $newDateTime=date("A",strtotime($time));
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
                       <td> 
                          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          مأثرات
                        </button>
                        <div class="dropdown-menu text-center">
                          <a class="dropdown-item has-icon" href="{{ route('SheftsTypes.edit',$info->id) }}"><i class="far fa-edit"></i> تعديل</a>
                          <a class="dropdown-item has-icon del" href="{{ route('SheftsTypes.destroy',$info->id) }}"><i class="
                            fas fa-trash" ></i>حذف</a>
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
   });
   
   
</script>
@endsection
