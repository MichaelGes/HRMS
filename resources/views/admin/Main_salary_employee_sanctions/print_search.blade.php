<!DOCTYPE html>
<html>


<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title id="title" style="display: none !important;">.</title>
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


</head>


   <style>
      @media print {
         .hidden-print {
            display: none;
         }
         
      }
      @media print {
         #printButton {
            display: none;
         }
      }
      table, th, td {
  border: 1px solid black !important;
  text-align: center !important;
  font-weight: 800 !important;
}


   </style>
<body style="font-family: Cairo;">
   <div class="loader"></div>
   <div id="app">
   <table class="" style="float:right;">
     <!-- <tr>
         <td style="text-align: center;padding: 5px;"> <span> نوع التقرير </span></td>
      </tr>--> 
      <tr>
         <td style="text-align: center;font-weight:bold;"> 
         <span >
               تقرير جزاءات الشهر   
            </span>
         </td>
      </tr>
      <tr>
         <td style="text-align: center;padding: 5px;font-weight: bold;">
            <span >
               طبع بتاريخ @php echo date('Y-m-d'); @endphp
            </span>
         </td>
      </tr>
      <tr>
         <td style="text-align: center;padding: 5px;font-weight: bold;">
            <span >
               طبع بواسطة {{ auth()->user()->name }}
            </span>
         </td>
      </tr>
   </table>
   
   <table class="tt"  dir="rtl">
      <tr>
         <td >
            <img style="width:120px;height:90px;border-radius: 10px;"
            src="{{ asset('assets/admin/upload/').'/'.$systemData['image'] }}">
            <p style="font-size:10px;font-weight:600">{{ $systemData['company_name'] }}</p>
         </td>
      </tr>
   </table>
   <br>
   @if (@isset($data) && !@empty($data) && count($data)>0)

   <table dir="rtl" class="table table-bordered table-md" style="width:100%">
      <thead style="background-color: #77B0AA">
         <th >م</th>
         <th style="width: 10%">كود الموظف</th>
         <th>اسم الموظف</th>
      
         <th style="width: 5%">عدد الايام</th>
         <th>الاجمالي</th>
         <th style="width: 7%" >تاريخ الاضافة</th>
         <th style="width: 7%">الحالة</th>
         </thead>
      </thead>
      <tbody> @php $i=1; @endphp
      <tbody>
         @foreach ($data as $info )
         <tr>
            <td style="background-color: rgb(227, 240, 250);"> {{ $i }} </td>
            <td> {{ $info->zketo_code }} </td>
            <td> {{ $info->emp_name }} </td>
            <td> @if($info->sanctions_type==1) جزاء ايام @elseif($info->sanctions_type==2) جزاء بصمة  @elseif($info->sanctions_type==3) جزاء تحقيق @else لم يحدد @endif</td>
            <td> {{ $info->value*1 }} </td>
            <td> {{ $info->total*1 }} ج.م</td>
            <td >
               @php    
               $dt=new DateTime($info->created_at);
               $date=$dt->format("Y-m-d");
             /*  $time=$dt->format("h:i");*/
               $newDateTime=date("a",strtotime($info->created_at));  
             @endphp
             {{ $date }}<br> 
          <!--- {{ $info->added->name }} --> 
           </td> 
           <td> @if($info->is_archived==1) مؤرشف  @else  مفتوح @endif
             @if ($info->is_open!=0 )
             <a href="#" class="btn load_the_open_model btn-danger btn-sm">عرض</a>
             @endif
       </td>  
         </tr>
         @php $i++; @endphp
         @endforeach
       
         <tr>
            <td style="background-color:#B3C8CF; font-weight:bold;" colspan="4"> اجمالي أعدد الموظفين - الأيام - مبلغ الجزاءات 
            </td>
            <td style="background-color: #B3C8CF;" > 
               <span style="font-weight:bold;"> {{ $other['value_sum']*1 }} </span>  يوم
               </td>
               <td style="background-color: #B3C8CF;text-align: center;"  colspan="1" > 
                <span style="font-weight:bold;font-size: 18px"> {{ $other['total_sum']*1 }} </span>   ج.م 
                  </td>
         </tr>
      </tbody>
   </table>
   <br>
   @else
 <div class="clearfix"></div>
      <p class="" style="text-align: center; font-size: 16px;font-weight: bold; color: brown">
      عفوا لاتوجد بيانات لعرضها !!
      </p>
   @endif
   <br>
   <p style="
         padding: 10px 10px 0px 10px;
         bottom: 0;
         width: 100%;
         /* Height of the footer*/ 
         text-align: center;font-size: 16px; font-weight: bold;
         "> {{ $systemData['address'] }} - {{ $systemData['phone'] }} </p>
   <div class="clearfix"></div> <br>
   <p class="text-center">
      <button onclick="window.print()" class="btn btn-primary" id="printButton">طباعة</button>
   </p>
</body>
</html>