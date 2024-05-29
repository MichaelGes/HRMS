<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance_calender;
use App\Http\Requests\finance_calenders_Request;
use App\Http\Requests\Finance_calendersUpdate;
use App\Models\Finance_cln_periods;
use App\Models\Monthes;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Concerns\InteractsWithInput;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class Finance_calendersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code=auth()->user()->com_code;
        $data= get_cols_where_p(new Finance_calender(),array("*"),array("com_code"=>$com_code),"id","DESC",PC);
        $ChackDataOpenCounter = Finance_calender::where(['is_open' => 1])->count();
        return view('admin.Finance_calender.index', ['data' => $data,'ChackDataOpenCounter'=>$ChackDataOpenCounter]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Finance_calender.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Finance_calenders_Request $request)
    {
        try {
            DB::beginTransaction();
            $dataToInsert['FINANCE_YR'] = $request->FINANCE_YR;
            $dataToInsert['FINANCE_YR_DESC'] = $request->FINANCE_YR_DESC;
            $dataToInsert['start_date'] = $request->start_date;
            $dataToInsert['end_date'] = $request->end_date;
            $dataToInsert['added_by'] = auth()->user()->id;
            $dataToInsert['com_code'] = auth()->user()->com_code;
            $falg = Finance_calender::insert($dataToInsert);
            if ($falg) {

                $dataParent = Finance_calender::select("id")->where($dataToInsert)->first();
                $startDate = new DateTime($request->start_date);
                $endDate = new DateTime($request->end_date);
                $dareInterval = new DateInterval('P1M');
                $datePerioud = new DatePeriod($startDate, $dareInterval, $endDate);

                foreach ($datePerioud as $date) {
                    $dataMonth['finance_calenders_id'] = $dataParent['id'];
                    $Montname_en = $date->format('F');
                    $dataParentMonth = Monthes::select("id")->where(['name_en' => $Montname_en])->first();
                    $dataMonth['MONTH_ID'] = $dataParentMonth['id'];
                    $dataMonth['FINANCE_YR'] = $dataToInsert['FINANCE_YR'];
                    $dataMonth['START_DATE_M'] = date('Y-m-01', strtotime($date->format('Y-m-d')));
                    $dataMonth['END_DATE_M'] = date('Y-m-t', strtotime($date->format('Y-m-d')));
                    $dataMonth['year_and_month'] = date('Y-m', strtotime($date->format('Y-m-d')));
                    $datediff = strtotime($dataMonth['END_DATE_M']) - strtotime($dataMonth['START_DATE_M']);
                    $dataMonth['number_of_days'] = round($datediff / (60 * 60 * 24)) + 1;
                    $dataMonth['com_code'] = auth()->user()->com_code;
                    $dataMonth['updated_at'] = date("Y-m-d H:i:s");
                    $dataMonth['created_at'] = date("Y-m-d H:i:s");
                    $dataMonth['added_by'] = auth()->user()->id;
                    $dataMonth['updated_by'] = auth()->user()->id;
                    $dataMonth['start_date_for_pasma'] = date('Y-m-01', strtotime($date->format('Y-m-d')));
                    $dataMonth['end_date_for_pasma'] = date('Y-m-t', strtotime($date->format('Y-m-d')));
                    Finance_cln_periods::insert($dataMonth);
                }
            }
            DB::commit();
            return redirect()->route('finance_calender.index')->with(['success' => 'تم الاضافة بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ اثناء التسجيل برجاء الرجوع الي المسؤل' . $ex->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Finance_calender $finance_calender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Finance_calender::select("*")->where(['id' => $id])->first();
        if (empty($data)) {
            return redirect()->back()->with(['error' => 'عفوا حدث حضا برجاء الرجوع الي المسؤل']);
        }
        if ($data['is_open'] !=0) {
            return redirect()->back()->with(['error' => 'عفوا لايمكن حذف سنة مالية مفتوحة']);     
        }
        return view ('admin.Finance_calender.update',['data'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Finance_calendersUpdate $request)
    {
        try{
            $data = Finance_calender::select("*")->where(['id' => $id])->first();
        if (empty($data)) {
            return redirect()->back()->with(['error' => 'عفوا حدث حضا برجاء الرجوع الي المسؤل']);
        }
        if ($data['is_open'] !=0) {
            return redirect()->back()->with(['error' => 'عفوا لايمكن حذف سنة مالية مفتوحة'])->WithInput();     
        }
        $validator=Validator::make($request->all(),[
            'FINANCE_YR'=>['required',Rule::unique('finance_calenders')->ignore($id)],
        ]);
        if($validator->fails()){
            return redirect()->back()->with(['error' => 'عفوا اسم السنة المالية مسجل من قبل'])->WithInput();
        }
        DB::beginTransaction();  
        $dataToUpdate['FINANCE_YR'] = $request->FINANCE_YR;
        $dataToUpdate['FINANCE_YR_DESC'] = $request->FINANCE_YR_DESC;
        $dataToUpdate['start_date'] = $request->start_date;
        $dataToUpdate['end_date'] = $request->end_date;
        $dataToUpdate['updated_by'] = auth()->user()->id;
        $falg = Finance_calender::where(['id'=>$id])->update($dataToUpdate);

        if($falg){
            if($data['start_date']!=$request->start_date or $data['end_date']!=$request->end_date)
            {
                $falgDelete=Finance_cln_periods::where(['finance_calenders_id'=>$id])->delete();
                if($falgDelete){ 
                    $startDate = new DateTime($request->start_date);
                    $endDate = new DateTime($request->end_date);
                    $dareInterval = new DateInterval('P1M');
                    $datePerioud = new DatePeriod($startDate, $dareInterval, $endDate);
    
                    foreach ($datePerioud as $date) {
                        $dataMonth['finance_calenders_id'] =$id;
                        $Montname_en = $date->format('F');
                        $dataParentMonth = Monthes::select("id")->where(['name_en' => $Montname_en])->first();
                        $dataMonth['MONTH_ID'] = $dataParentMonth['id'];
                        $dataMonth['FINANCE_YR'] = $dataToUpdate['FINANCE_YR'];
                        $dataMonth['START_DATE_M'] = date('Y-m-01', strtotime($date->format('Y-m-d')));
                        $dataMonth['END_DATE_M'] = date('Y-m-t', strtotime($date->format('Y-m-d')));
                        $dataMonth['year_and_month'] = date('Y-m', strtotime($date->format('Y-m-d')));
                        $datediff = strtotime($dataMonth['END_DATE_M']) - strtotime($dataMonth['START_DATE_M']);
                        $dataMonth['number_of_days'] = round($datediff / (60 * 60 * 24)) + 1;
                        $dataMonth['com_code'] = auth()->user()->com_code;
                        $dataMonth['updated_at'] = date("Y-m-d H:i:s");
                        $dataMonth['created_at'] = date("Y-m-d H:i:s");
                        $dataMonth['added_by'] = auth()->user()->id;
                        $dataMonth['updated_by'] = auth()->user()->id;
                        $dataMonth['start_date_for_pasma'] = date('Y-m-01', strtotime($date->format('Y-m-d')));
                        $dataMonth['end_date_for_pasma'] = date('Y-m-t', strtotime($date->format('Y-m-d')));
                        Finance_cln_periods::insert($dataMonth);
                    }

                }
            }

        }
        DB::commit();
        return redirect()->route('finance_calender.index')->with(['success'=>'تم تحديث السنة المالية بنجاح']);

        }catch(\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with(['error'=>'عفوا جدث حطأ ما'.$ex->getMessage()]);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Finance_calender::select("*")->where(['id' => $id])->first();
            if (empty($data)) {
                return redirect()->back()->with(['error' => 'عفوا حدث حضا برجاء الرجوع الي المسؤل']);
            }
            if ($data['is_open'] !=0) {
                return redirect()->back()->with(['error' => 'عفوا لايمكن حذف سنة مالية مفتوحة']);
            }
            $flag = Finance_calender::where(['id' => $id])->delete();
            if ($flag) {
                Finance_cln_periods::where(['finance_calenders_id' => $id])->delete();
            }
            return redirect()->route('finance_calender.index')->with(['success' => 'تم حذف السنة المالية بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث حضا برجاء الرجوع الي المسؤل'] . $ex->getMessage());
        }
    }

    public function do_open($id)
    {
        try {
            $data = Finance_calender::select("*")->where(['id' => $id])->first();
            if (empty($data)) {
                return redirect()->back()->with(['error' => 'عفوا حدث حضا برجاء الرجوع الي المسؤل']);
            }
            if ($data['is_open'] !=0) {
                return redirect()->back()->with(['error' => 'عفوا لايمكن فتح سنة مالية مفتوحة']);
            }
            $ChackDataOpenCounter = Finance_calender::where(['is_open' => 1])->count();
            if ($ChackDataOpenCounter>0) {
                return redirect()->back()->with(['error' => 'عفوا مازلات هناك سنة مالية مفتوحة']);
            }
            $dataToupdate['is_open']=1;
            $dataToupdate['updated_by']=auth()->user()->id;     
            $flag = Finance_calender::where(['id' => $id])->update($dataToupdate);
          
            return redirect()->route('finance_calender.index')->with(['success' => 'تم تحديث بيانات السنة المالية بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عفوا حدث حضا برجاء الرجوع الي المسؤل'] . $ex->getMessage());
        }
    }

    function show_year_monthes(Request $request){
        if($request->ajax()){
            $finance_cln_periods=Finance_cln_periods::select("*")->where(['finance_calenders_id'=>$request->id])->get();
            return view("admin.Finance_calender.show_year_monthes",['finance_cln_periods'=>$finance_cln_periods]);
        }

    }
}
