<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Admin_panel_setting;
use Illuminate\Http\Request;
use App\Http\Requests\Admin_panel_settingRequest;

class Admin_panel_settingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = Admin_panel_setting::select('*')->where('com_code', $com_code)->first();
        return view('admin.Admin_panel_setting.index', ['data' => $data]);
    }


    /**
     * Show the form for editing the specified resource.
     */

    public function edit()
    {
        $com_code = auth()->user()->com_code;
        $data = Admin_panel_setting::select('*')->where('com_code', $com_code)->first();
        return view('admin.Admin_panel_setting.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Admin_panel_settingRequest $request)
    {
        try {
            $com_code=auth()->user()->com_code;
            $data = Admin_panel_setting::select('image')->where('com_code', $com_code)->first();
            $dataToUpdate['company_name']=$request->company_name;
            $dataToUpdate['phones']=$request->phones;
            $dataToUpdate['address']=$request->address;
            $dataToUpdate['email']=$request->email;
            $dataToUpdate['after_miniute_calculate_delay']=$request->after_miniute_calculate_delay;
            $dataToUpdate['after_miniute_calculate_early_departure']=$request->after_miniute_calculate_early_departure;
            $dataToUpdate['after_miniute_quarterday']=$request->after_miniute_quarterday;
            $dataToUpdate['after_time_half_daycut']=$request->after_time_half_daycut;
            $dataToUpdate['after_time_allday_daycut']=$request->after_time_allday_daycut;
            $dataToUpdate['monthly_vacation_balance']=$request->monthly_vacation_balance;
            $dataToUpdate['after_days_begin_vacation']=$request->after_days_begin_vacation;
            $dataToUpdate['first_balance_begin_vacation']=$request->first_balance_begin_vacation;
            $dataToUpdate['sanctions_value_first_abcence']=$request->sanctions_value_first_abcence;
            $dataToUpdate['sanctions_value_second_abcence']=$request->sanctions_value_second_abcence;
            $dataToUpdate['sanctions_value_thaird_abcence']=$request->sanctions_value_thaird_abcence;
            $dataToUpdate['sanctions_value_forth_abcence']=$request->sanctions_value_forth_abcence;
            $dataToUpdate['updated_by']=auth()->user()->id;

     //img_upload
     if ($request->has('image_edit')) {
        $request->validate([
            'image_edit' => 'required|mimes:png,jpg,jpeg|max:2000',
        ]);
        $the_file_path = uploadImage('assets/admin/upload', $request->image_edit);
        $dataToUpdate['image'] =  $the_file_path;

        if (file_exists('assets/admin/upload/' . $data['image']) and !empty($data['image'])) {
            unlink('assets/admin/upload/' . $data['image']);
        }
    }

            Admin_panel_setting::where(['com_code'=>$com_code])->update($dataToUpdate);
            return redirect()->route('admin_panel_settings.index')->with(['success'=>'تم تحديث بيانات الشركة بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->back()->with(['error' => 'عقوا حدث حظا ما اثناء تحدث البيانات برجاء الرجوع الي المسؤل'])->withInput();
        }
    }
}
