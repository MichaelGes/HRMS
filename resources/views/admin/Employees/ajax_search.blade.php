 <div class="card-body" id="ajax_responce_serachDiv">
            @if(@isset($data) and !@empty($data) and count($data)>0)
            <div class="table-responsive text-center">
              <table id="mainTable " class="table table-striped text-center">
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