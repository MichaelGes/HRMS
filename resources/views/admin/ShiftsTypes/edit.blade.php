@extends('layouts.admin')
@section('title')
ضبط الفروع
@endsection
@section('content')

<div class="col-12" >
    <div class="card ">
        <a href="{{ route('branches.create') }}" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i>تعديل</a>
      <div class="card-header">
        <h4 style="width: 100%;text-align:center">تعديل الشيفت</h4>  
      </div>
      <div class="card-body">

      <form action="{{ route('SheftsTypes.update',$data['id']) }}" method="post">
        <div class="row">
      @csrf
      </form>     
      <div class="col-md-4">
         <div class="form-group">
            <label>نوع الشيفت</label>
            <select name="type" id="type" class="form-control">
               <option selected value="">اختر نوع الشيفت</option>
               <option @if(old('type',$data['type'])==1) selected @endif value="1">الاولي</option>
               <option @if(old('type',$data['type'])==2) selected @endif value="2">الثانية</option>
               <option @if(old('type',$data['type'])==3) selected @endif value="3">الثالثة</option>
               <option @if(old('type',$data['type'])==3) selected @endif value="4">يوم كامل</option>
            </select>
            @error('type')
            <span class="text-danger">{{ $message }}</span> 
            @enderror
         </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
           <label>يبداء من الساعة </label>
           <input type="time" name="from_time" id="from_time" class="form-control" value="{{old('from_time',$data['from_time'])  }}"    >
           @error('from_time')
           <span class="text-danger">{{ $message }}</span> 
           @enderror
        </div>
     </div>

     <div class="col-md-4">
      <div class="form-group">
         <label>ينتهي في الساعة</label>
         <input type="time" name="to_time" id="to_time" class="form-control" value="{{old('to_time',$data['to_time'])  }}"    >
         @error('to_time')
         <span class="text-danger">{{ $message }}</span> 
         @enderror
      </div>
   </div>

   <div class="col-md-4">
      <div class="form-group">
         <label>عدد ساعات الشيفت</label>
         <input type="text" name="total_hour" id="total_hour" class="form-control" value="{{old('total_hour',$data['total_hour'])  }}"  oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  >
         @error('total_hour')
         <span class="text-danger">{{ $message }}</span> 
         @enderror
      </div>
   </div>

   <div class="col-md-4">
      <div class="form-group">
         <label>حالة التفعيل</label>
         <select name="active" id="active" class="form-control">
            <option @if(old('active',$data['active'])==1) selected @endif value="1">مفعل</option>
            <option @if(old('active',$data['active'])==0) selected @endif value="0">غير مفعل</option>
         </select>
         @error('active')
         <span class="text-danger">{{ $message }}</span> 
         @enderror
      </div>
   </div>


     <div class="col-md-12 text-center">
      <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">تعديل الشيفت</button>
      </div>
    </div>
</div>
</div>

    

@endsection