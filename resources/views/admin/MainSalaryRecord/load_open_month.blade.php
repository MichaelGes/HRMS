@if(@isset($data) and !@empty($data) )
@if($data['is_open']==0)
      <div class="card-body">
      <form action="{{ route('MainSalaryRecord.do_open_month',$data['id']) }}" method="post">
        <div class="row">
      @csrf
      </form>     
  
      <div class="col-md-6">
        <div class="form-group">
           <label>تاريخ بداية البصمة للشهر</label>
           <input type="date" name="start_date_for_pasma" id="start_date_for_pasma" class="form-control" value="{{$data['start_date_for_pasma']  }}"    >
        </div>
     </div>

     <div class="col-md-6">
      <div class="form-group">
         <label>تاريخ نهاية البصمة للشهر</label>
         <input type="date" name="end_date_for_pasma" id="end_date_for_pasma" class="form-control" value="{{$data['end_date_for_pasma']  }}"    >
      </div>
   </div>

   
     <div class="col-md-12 text-center">
      <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary are_you_shur">فتح الشهر الان</button>
      </div>
    </div>
</div>
@endif
@else
<p class="bg-danger text-center"> عفوا لاتوجد بيانات لعرضها</p>
@endif