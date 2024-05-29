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
              <a href="{{ route('finance_calender.create') }}" class="btn btn-primary">اضافة جديد</a>
              <div class="card-header">
                <h4>بيانات السنة المالية</h4>
              </div>
              <div class="card-body">
                @if(@isset($data) and !@empty($data) and count($data)>0 )
                <div class="table-responsive text-center">
                  <table id="mainTable " class="table table-striped text-center">
                    <thead>
                      <tr>
                        <th> كود السنة</th>
                        <th> وصف السنة</th>
                        <th>  تاريخ البداية</th>
                        <th>  تاريخ النهاية</th>
                        <th>  الاضافة بواسطة</th>
                        <th>  التحديث بواسطة</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ( $data as $info )
                      <tr>
                        <td> {{ $info->FINANCE_YR }} </td>
                        <td> {{ $info->FINANCE_YR_DESC }} </td>
                        <td> {{ $info->start_date }} </td>
                        <td> {{ $info->end_date }} </td>
                        <td>{{ $info->added->name }} </td>
                        <td>
                          @if($info->updated_by>0)
                       {{ $info->updatedby->name }} 
                       @else
                       لايوجد
                       @endif
                       </td>
                       <td>
                          @if($info->is_open==0)
                          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          مأثرات
                        </button>
                        <div class="dropdown-menu text-center">
                          @if($ChackDataOpenCounter==0)
                          <a class="dropdown-item has-icon" href="{{ route('finance_calender.do_open',$info->id) }}"><i class="far fa-heart"></i> فتح</a>
                          @endif
                          <a class="dropdown-item has-icon" href="{{ route('finance_calender.edit',$info->id) }}"><i class="far fa-edit"></i> تعديل</a>
                          <a class="dropdown-item has-icon are_you_shur del" href="{{ route('finance_calender.delete',$info->id) }}"><i class="
                            fas fa-trash" ></i>حذف</a>
                        </div>
                          @else
                          <h4>
                          <div class="badge badge-success">سنة مالية مفتوحة</div>
                        </h4>
                          @endif
                          <button class="btn btn-info btn-sm show_year_monthes" style="font-size: 13px" data-id="{{ $info->id }}" > <i class="fas fa-eye" style="padding-top: 7px"> </i> عرض الشهور</button>
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
    </section>
@endsection

  <!-- Large modal -->
  <div class="modal fade " id="show_year_monthesModal" >
    <div class="modal-dialog modal-xl">
      <div class="modal-content bg-info">
        <div class="modal-header">
          <h4 class="modal-title">عرض الشهور  للسنة المالية</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body bg-white" id="show_year_monthesModalBody" >
   
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
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
