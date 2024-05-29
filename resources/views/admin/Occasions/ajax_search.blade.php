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
       
        <td>  @if($info->type==1)  الاولي  @elseif($info->type==2)  الثانية  @else  الثالثة  @endif </td>
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