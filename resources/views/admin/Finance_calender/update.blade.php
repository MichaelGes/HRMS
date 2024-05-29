@extends('layouts.admin')
@section('title')
ضبط السنوات المالية
@endsection
@section('content')

<!--col-md-6 col-lg-6-->
<div class="col-12" >
    <div class="card ">
        <a href="{{ route('finance_calender.create') }}" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i>اضافة</a>
      <div class="card-header">
        <h4 style="width: 100%;text-align:center">تعديل سنة مالية جديدة</h4>  
      </div>
      <div class="card-body">

      <form action="{{ route('finance_calender.update',$data['id']) }}" method="post">
        <div class="row">
      @csrf
      @method('PUT')
      </form>     
      <div class="col-md-4">
        <div class="form-group">
           <label>كود السنة المالية </label>
           <input type="text" name="FINANCE_YR" id="FINANCE_YR" class="form-control" value="{{old('FINANCE_YR',$data['FINANCE_YR'])  }}"    >
           @error('FINANCE_YR')
           <span class="text-danger">{{ $message }}</span> 
           @enderror
        </div>
     </div>
     <div class="col-md-4">
        <div class="form-group">
           <label>وصف السنة المالية</label>
           <input type="text" name="FINANCE_YR_DESC" id="FINANCE_YR_DESC" class="form-control" value="{{old('FINANCE_YR_DESC',$data['FINANCE_YR_DESC'])  }}" placeholder="">
           @error('FINANCE_YR_DESC')
           <span class="text-danger">{{ $message }}</span> 
           @enderror
        </div>
     </div>
     <div class="col-md-4">
      <div class="form-group">
         <label>تاريخ بدايةالسنةالمالية</label>
         <input type="date" name="start_date" id="start_date" class="form-control" value="{{old('start_date',$data['start_date'])  }}" placeholder="">
         @error('start_date')
         <span class="text-danger">{{ $message }}</span> 
         @enderror
      </div>
   </div>
   <div class="col-md-4">
    <div class="form-group">
       <label>تاريخ انهاءالسنةالمالية</label>
       <input type="date" name="end_date" id="end_date" class="form-control" value="{{old('end_date',$data['end_date'])  }}" placeholder="">
       @error('end_date')
       <span class="text-danger">{{ $message }}</span> 
       @enderror
    </div>
 </div>
     <div class="col-md-12 text-center">
      <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">تحديث السنة</button>
      </div>
    </div>
</div>

    

@endsection