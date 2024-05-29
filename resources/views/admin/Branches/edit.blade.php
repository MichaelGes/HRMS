@extends('layouts.admin')
@section('title')
ضبط الفروع
@endsection
@section('content')

<div class="col-12" >
    <div class="card ">
        <a href="{{ route('branches.create') }}" class="btn btn-icon icon-left btn-primary"><i class="far fa-edit"></i>تعديل</a>
      <div class="card-header">
        <h4 style="width: 100%;text-align:center">تعديل بيانات الفرع</h4>  
      </div>
      <div class="card-body">

      <form action="{{ route('branches.Update',$data['id']) }}" method="post">
        <div class="row">
      @csrf
      </form>     
      <div class="col-md-4">
        <div class="form-group">
           <label>الاسم</label>
           <input type="text" name="name" id="name" class="form-control" value="{{old('name',$data['name'])}}"    >
           @error('name')
           <span class="text-danger">{{ $message }}</span> 
           @enderror
        </div>
     </div>

     <div class="col-md-4">
      <div class="form-group">
         <label>العنوان</label>
         <input type="text" name="address" id="address" class="form-control" value="{{old('address',$data['address'])  }}"    >
         @error('address')
         <span class="text-danger">{{ $message }}</span> 
         @enderror
      </div>
   </div>

     <div class="col-md-4">
      <div class="form-group">
         <label>الهاتف</label>
         <input type="text" name="phones" id="phones" class="form-control" value="{{old('phones',$data['phones'])  }}"    >
         @error('phones')
         <span class="text-danger">{{ $message }}</span> 
         @enderror
      </div>
   </div>

   <div class="col-md-4">
      <div class="form-group">
         <label>الايميل</label>
         <input type="text" name="email" id="email" class="form-control" value="{{old('email',$data['email'])  }}"    >
         @error('email')
         <span class="text-danger">{{ $message }}</span> 
         @enderror
      </div>
   </div>

   <div class="col-md-4">
      <div class="form-group">
         <label>حالة التفعيل</label>
         <select name="active" id="active" class="form-control">
            <option {{ old('active',$data['active'])==1 ? 'selected':'' }} value="1">مفعل</option>
            <option {{ old('active',$data['active'])==0 ? 'selected':'' }} value="0">غير مفعل</option>
         </select>
         @error('active')
         <span class="text-danger">{{ $message }}</span> 
         @enderror
      </div>
   </div>


     <div class="col-md-12 text-center">
      <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">تحديث</button>
      </div>
    </div>
</div>
</div>

    

@endsection