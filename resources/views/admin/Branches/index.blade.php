@extends('layouts.admin')
@section('title')
السنوات المالية
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
              <a href="{{ route('branches.create') }}" class="btn btn-primary">اضافة جديد</a>
              <div class="card-header">
                <h4>بيانات الفروع</h4>
              </div>
              <div class="card-body">
                @if(@isset($data) and !@empty($data) )
                <div class="table-responsive text-center">
                  <table id="mainTable" class="table table-striped text-center">
                    <thead>
                      <tr>
                        <th>كودالفرع</th>
                        <th>اسم الفرع</th>
                        <th>العنوان</th>
                        <th>الهاتف</th>
                        <th>الايميل</th>
                        <th>حالة التفعيل</th>
                        <th>الاضافة بواسطة</th>
                        <th>التحديث بواسطة</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ( $data as $info )
                      <tr>
                        <td> {{ $info->id }} </td>
                        <td> {{ $info->name }} </td>
                        <td> {{ $info->address }} </td>
                        <td> {{ $info->phones }} </td>
                        <td> {{ $info->email }} </td>
                        <td @if ($info->active==1) class="bg-success" @else class="bg-danger" @endif> @if ($info->active==1) مفعل @else معطل @endif </td>
                        <td>{{ $info->added->name }} </td>
                        <td>
                          @if($info->updated_by>1)
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
                          <a class="dropdown-item has-icon" href="{{ route('branches.Edit',$info->id) }}"><i class="far fa-edit"></i> تعديل</a>
                          <a class="dropdown-item has-icon del are_you_shur" href="{{ route('branches.destroy',$info->id) }}"><i class="
                            fas fa-trash" ></i>حذف</a>
                          
                        </div>         
                       </td>
                    </tr>
                    @endforeach
                 </tbody>
              </table>
              @else
              <p class="bg-danger text-center"> عفوا لاتوجد بيانات لعرضها</p>
              @endif
           </div>
          </div>
          </div>
        </div>
     </div>     
    </section>
@endsection



@section('script')
@section('script')
<script>
   $(document).ready(function(){
      $(document).on('click','.show_year_monthes',function(){
    var id=$(this).data('id');
    jQuery.ajax({
   url:'{{ route('finance_calender.show_year_monthes') }}',
   type:'post',
   'dataType':'html',
   cache:false,
   data:{ "_token":'{{ csrf_token() }}','id':id },
   success:function(data){
   $("#show_year_monthesModalBody").html(data);
   $("#show_year_monthesModal").modal("show");
   },
   error:function(){
   
   }
   
    });
   
   
      });
   });
   
   
</script>
@endsection
