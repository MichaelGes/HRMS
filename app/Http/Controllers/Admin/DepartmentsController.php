<?php

namespace App\Http\Controllers\Admin;

use App\Models\Departments;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentsRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_p(new Departments(), array("*"), array('com_code' => $com_code), 'id', 'DESC', PC);
        return view('admin.Departments.index', ['data' => $data]);
    }
    public function create()
    {
        return view('admin.Departments.create');
    }
    public function store(DepartmentsRequest $requset)
    {
        try {
            $com_code = auth()->user()->com_code;
            $checkExsists = get_cols_where_row(new Departments(), array('id'), array("com_code" => $com_code,'name'=>$requset->name));
            if (!empty($checkExsists)) {
                return redirect()->back()->with(['error' => 'عفوا اسم الادارة مسجل من قبل'])->withInput();
            }
            DB::beginTransaction();
            $dataToinsert['name'] = $requset->name;
            $dataToinsert['phones'] = $requset->phones;
            $dataToinsert['notes'] = $requset->notes;
            $dataToinsert['active'] = $requset->active;
            $dataToinsert['added_by'] = auth()->user()->id;
            $dataToinsert['com_code'] = $com_code;
            insert(new Departments(), $dataToinsert);
            DB::commit();
            return redirect()->route('departments.index')->with(['success' => 'تم اضافة الادارة الجديدة بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث حطا ما' . $ex->getMessage()])->withInput();
        }
    }
    public function edit($id){
        $com_code = auth()->user()->com_code;
        $data=get_cols_where_row(new Departments(),array("*"),array('com_code'=>$com_code,'id'=>$id));
        if(empty($data)){
            return redirect()->route('departments.index')->with(['error'=>'عفوا لا يمكنك التحديث ']);
        }
       return view('admin.Departments.edit',['data'=>$data]);
    }
    public function update($id, DepartmentsRequest $requset)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new Departments(), array("*"), array('com_code' => $com_code, 'id' => $id));
            if (empty($data)) {
                return redirect()->route('departments.index')->with(['error' => 'عفوا غير قادر الي الوصول البي البيانات المطلوبة !']);
            }
            $CheckExsists = Departments::select("id")->where('com_code', '=', $com_code)->where('name', '=', $requset->name)->where('id', '!=', $id)->first();
            if (!empty($CheckExsists)) {
                return redirect()->back()->with(['error' => 'عفوا اسم الادارة مسجل من قبل !'])->withInput();
            }
            DB::beginTransaction();
            $dataToUpdate['name'] = $requset->name;
            $dataToUpdate['phones'] = $requset->phones;
            $dataToUpdate['notes'] = $requset->notes;
            $dataToUpdate['active'] = $requset->active;
            $dataToUpdate['updated_by'] = auth()->user()->id;
            update(new Departments(), $dataToUpdate, array('com_code' => $com_code, 'id' => $id));
            DB::commit();
            return redirect()->route('departments.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ ما ' . $ex->getMessage()])->withInput();
        }
    }
    public function destroy($id)
    {
        try {
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new Departments(), array("*"), array('com_code' => $com_code, 'id' => $id));
            if (empty($data)) {
                return redirect()->route('departments.index')->with(['error' => 'عفوا غير قادر الي الوصول البي البيانات المطلوبة !']);
            }
            DB::beginTransaction();
            destroy(new Departments(), array('com_code' => $com_code, 'id' => $id));
            DB::commit();
            return redirect()->route('departments.index')->with(['success' => 'تم حذف البيانات بنجاح']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ ما ' . $ex->getMessage()])->withInput();
        }
    }
}
