@if(@isset($data) and !@empty($data) and count($data)>0)
<div class="table-responsive text-center">
  <table id="mainTable" class="table table-striped text-center" style="direction: rtl !important;text-align: center">
    <thead class="custom_thead">  
       <th>كود الموظف</th>
       <th>اسم الموظف</th>
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
       <td> 
          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          مأثرات
        </button>
        <div class="dropdown-menu text-center">

          @if($info->is_archived==0)
          <button class="btn btn-success sm load_edit_this_row" data-id="{{ $info->id }}" data-main_salary_employee_id="{{ $info->main_salary_employee_id }}" class="dropdown-item has-icon load_edit_this_row " > تعديل</button>
          <button class="btn btn-danger sm delete_this_row"  data-id="{{ $info->id }}" data-main_salary_employee_id="{{ $info->main_salary_employee_id }}" class="dropdown-item has-icon delete_this_row" >    حذف</button>
          @endif
        </div>         
        </td>
       @endforeach
    </tbody>
 </table>    
<br/>
<div class="col-md-12 text-center" id="ajax_pagination_in_search">
  {{ $data->links('pagination::bootstrap-5') }}
  </div>
@else
<p class="bg-danger text-center"> عفوا لاتوجد بيانات لعرضها</p>
@endif