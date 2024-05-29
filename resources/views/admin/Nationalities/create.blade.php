@extends('layouts.admin')
@section('title')
اضافة المناسبات الرسمية
@endsection
@section('content')
<!--col-md-6 col-lg-6-->
<div class="col-12" >
    <div class="card ">
      <div class="card-header">
        <h4 style="width: 100%;text-align:center">انشاء المناسبات الرسمية</h4>  
      </div>
      <div class="card-body">
      <form action="{{ route('Nationalities.store') }}" method="post">
        <div class="row">
      @csrf

   <div class="col-md-4">
      <div class="form-group">
         <label>اسم الجنسية</label>
         <input type="text" name="name" id="name" class="form-control" value="{{old('name')  }}" >
         @error('name')
         <span class="text-danger">{{ $message }}</span> 
         @enderror
      </div>
   </div>

   <div class="col-md-4">
      <div class="form-group">
         <label>حالة التفعيل</label>
         <select name="active" id="active" class="form-control">
            <option @if(old('active')==1) selected @endif value="1">مفعل</option>
            <option @if(old('active')==0 and old('avtive')!='') selected @endif value="0">غير مفعل</option>
         </select>
         @error('active')
         <span class="text-danger">{{ $message }}</span> 
         @enderror
      </div>
   </div>


     <div class="col-md-12 text-center">
      <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">اضافة المناسبة</button>
      </div>
    </div>
</div>
</form>    
</div>
@endsection