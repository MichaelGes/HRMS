@extends('layouts.admin')
@section('title')
ضبط جنسيات الموظفين
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
          <a href="{{ route('Nationalities.create') }}" class="btn btn-primary">اضافة جديد</a>
          <div class="card-header">
            <h4>بيانات انواع ترك العمل</h4>
          </div>
          <div class="card-body" id="ajax_responce_serachDiv">
            @if(@isset($data) and !@empty($data) and count($data)>0)
            <div class="table-responsive text-center">
              <table id="mainTable " class="table table-striped text-center">
                <thead>
                  <tr>
                    <th>الجنسية</th> 
                    <th>حالة التفعيل</th>
                    <th>الاضافة بواسطة</th>
                    <th>التحديث بواسطة</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $data as $info )
                  <tr>
                    <td>{{ $info->name }}</td>      
                    <td @if ($info->active==1) class="bg-success" @else class="bg-danger" @endif> @if ($info->active==1) مفعل @else معطل @endif </td>
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
                    <td> 
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      مأثرات
                    </button>
                    <div class="dropdown-menu text-center">
                      <a class="dropdown-item has-icon" href="{{ route('Resignations.edit',$info->id) }}"><i class="far fa-edit"></i> تعديل</a>
                      <a class="dropdown-item has-icon are_you_shur del" href="{{ route('Resignations.destroy',$info->id) }}"><i class="
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

