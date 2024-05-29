@extends('layouts.admin')
@section('title')
ضبط الفروع
@endsection
@section('content')

<div class="col-12" >
    <div class="card ">
    <!--    <a href="{{ route('branches.create') }}" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i>تعديل</a>-->
      <div class="card-header">
        <h4 style="width: 100%;text-align:center">تعديل بيانات الادارات</h4>  
      </div>
      <div class="card-body">

      <form action="{{ route('departments.update',$data['id']) }}" method="post">
        <div class="row">
      @csrf
      <div class="col-md-4">
         <div class="form-group">
            <label>اسم الادارة</label>
            <input type="text" name="name" id="name" class="form-control" value="{{old('name',$data['name'])  }}" >
            @error('name')
            <span class="text-danger">{{ $message }}</span> 
            @enderror
         </div>
      </div>
   
      <div class="col-md-4">
         <div class="form-group">
            <label>هاتف الادارة</label>
            <input type="text" name="phones" id="phones" class="form-control" value="{{old('phones',$data['phones'])  }}" >
            @error('phones')
            <span class="text-danger">{{ $message }}</span> 
            @enderror
         </div>
      </div>
   
      <div class="col-md-4">
         <div class="form-group">
            <label>ملاحظات</label>
            <input type="text" name="notes" id="notes" class="form-control" value="{{old('notes',$data['notes'])  }}" >
            @error('notes')
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
        <button type="submit" name="submit" class="btn btn-primary">تعديل الادارة</button>
      </div>
    </div>
   </form>     
</div>
</div>

    

@endsection