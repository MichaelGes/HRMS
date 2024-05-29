<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Finance_calender;
use App\Models\Finance_cln_periods;
use App\Models\employee;
use App\Models\Main_salary_employee;

use App\Models\Admin_panel_setting;
use App\Models\Main_salary_employee_absence;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\alert;

class Main_salary_employee_absenceController extends Controller
{
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_p_order2(new Finance_cln_periods(), array("*"), array("com_code" => $com_code), 'FINANCE_YR', 'DESC', 'MONTH_ID', 'ASC', 12);
        if (!empty($data)) {
            foreach ($data as $info) {
                //check the month is open or not
                $info->currentYear = get_cols_where_row(new Finance_calender(), array("is_open"), array("com_code" => $com_code, "FINANCE_YR" => $info->FINANCE_YR));
                $info->counterOpenMonth = get_count_where(new Finance_cln_periods(), array("com_code" => $com_code, "is_open" => 1));
                $info->counterPreviousMonthWatingOpen = Finance_cln_periods::where("com_code", "=", $com_code)
                    ->where("FINANCE_YR", "=", $info->FINANCE_YR)->where("MONTH_ID", "<", $info->MONTH_ID)
                    ->where("is_open", "=", 0)->count();
            }
        }
        return view('admin.Main_salary_employee_absence.index', ['data' => $data]);
    }
    public function show($finance_cln_periods_id)
    {
        $com_code = auth()->user()->com_code;
        $finance_cln_periods_data = get_cols_where_row(new Finance_cln_periods(), array("*"), array("com_code" => $com_code, "id" => $finance_cln_periods_id));
        if (empty($finance_cln_periods_data)) {
            return redirect()->route('Main_salary_employee_absence.index')->with(['error' => 'عفوا غير قادر الي الوصول الي البيانات المطلوبة']);
        }
        $data = get_cols_where_p(new Main_salary_employee_absence(), array("*"), array("com_code" => $com_code, "finance_cln_periods_id" => $finance_cln_periods_id), 'id', 'DESC', PC);
        if (!empty($data)) {
            foreach ($data as $info) {
                $info->emp_name = get_field_value(new employee(), "emp_name", array("com_code" => $com_code, "employees_code" => $info->employees_code));
                $info->zketo_code = get_field_value(new employee(), "zketo_code", array("com_code" => $com_code, "employees_code" => $info->employees_code));
            }
        }
        $employees = Main_salary_employee::where("com_code","=",$com_code)->where("finance_cln_periods_id","=",$finance_cln_periods_id)->distinct()->get("employees_code");
        if(!empty($employees)){
            foreach($employees as $info){
                $info->EmployeeData=get_cols_where_row(new employee(), array("emp_name", "emp_sal", "day_price", "zketo_code"),array("com_code"=>$com_code,"employees_code"=>$info->employees_code));
            }
        }
        $employees_for_search=get_cols_where(new employee(), array("employees_code", "emp_name", "emp_sal", "day_price", "zketo_code"), array("com_code" => $com_code), 'employees_code', 'ASC');
        return view('admin.Main_salary_employee_absence.show', ['data' => $data, 'finance_cln_periods_data' => $finance_cln_periods_data, 'employees' => $employees,'employees_for_search'=>$employees_for_search]);
    }
    public function checkExsistsBefor(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $checkExsistsBeforCounter = get_count_where(new Main_salary_employee_absence(), array("com_code" => $com_code, "finance_cln_periods_id" => $request->the_finance_cln_periods_id, "employees_code" => $request->employees_code));
            if ($checkExsistsBeforCounter > 0) {
                return json_encode("exsists_befor");
            } else {
                return json_encode("no_exsists_befor");
            }
        }
    }
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $com_code = auth()->user()->com_code;
            $finance_cln_periods_data = get_cols_where_row(new Finance_cln_periods(), array("id"), array("com_code" => $com_code, "id" => $request->finance_cln_periods_id, 'is_open' => 1));
            $main_salary_employee_data  = get_cols_where_row(new Main_salary_employee(), array("*"), array("com_code" => $com_code, "finance_cln_periods_id" => $request->finance_cln_periods_id, 'employees_code' => $request->employees_code, 'is_archived' => 0));
            if (!empty($finance_cln_periods_data) and !empty($main_salary_employee_data)) {
                DB::beginTransaction();
                $dataToInsert['main_salary_employee_id'] = $main_salary_employee_data['id'];
                $dataToInsert['finance_cln_periods_id'] = $request->finance_cln_periods_id;
                $dataToInsert['is_auto'] = 1;
                $dataToInsert['employees_code'] = $request->employees_code;
                $dataToInsert['emp_day_price'] = $request->emp_day_price;
                $dataToInsert['value'] = $request->value;
                $dataToInsert['total'] = $request->total;
                $dataToInsert['notes'] = $request->notes;
                $dataToInsert['added_by'] = auth()->user()->id;
                $dataToInsert['com_code'] = $com_code;
                insert(new Main_salary_employee_absence(), $dataToInsert);
                DB::commit();
                return json_encode("store");
            }
        }
    }
    public function ajax_search(Request $request)
    {
        if ($request->ajax()) {
            $employees_code = $request->employees_code;
            $is_archived = $request->is_archived;
            $the_finance_cln_periods_id = $request->the_finance_cln_periods_id;

            if ($employees_code == 'all') {
                //هنا نعمل شرط دائم التحقق
                $field1 = "id";
                $operator1 = ">";
                $value1 = 0;
            } else {
                $field1 = "employees_code";
                $operator1 = "=";
                $value1 = $employees_code;
            }
   
            if ($is_archived == 'all') {
                //هنا نعمل شرط دائم التحقق
                $field2 = "id";
                $operator2 = ">";
                $value2 = 0;
            } else {
                $field2 = "is_archived";
                $operator2 = "=";
                $value2 = $is_archived;
            }
            $com_code = auth()->user()->com_code;
            $data = Main_salary_employee_absence::select("*")->where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where('finance_cln_periods_id', '=', $the_finance_cln_periods_id)->where('com_code', '=', $com_code)->orderby('id', 'DESC')->paginate(PC);
            if (!empty($data)) {
                foreach ($data as $info) {
                    $info->emp_name = get_field_value(new employee(), "emp_name", array("com_code" => $com_code, "employees_code" => $info->employees_code));
                    $info->zketo_code = get_field_value(new employee(), "zketo_code", array("com_code" => $com_code, "employees_code" => $info->employees_code));
                }
            }

            return view('admin.Main_salary_employee_absence.ajax_search', ['data' => $data]);
        }
    }


    public function delete_row(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $finance_cln_periods_data = get_cols_where_row(new Finance_cln_periods(), array("id"), array("com_code" => $com_code, "id" => $request->the_finance_cln_periods_id, 'is_open' => 1));
            $main_salary_employee_data  = get_cols_where_row(new Main_salary_employee(), array("id"), array("com_code" => $com_code, "finance_cln_periods_id" => $request->the_finance_cln_periods_id, 'id' => $request->main_salary_employee_id, 'is_archived' => 0));
            $data_row = get_cols_where_row(new Main_salary_employee_absence(), array("id"), array("com_code" => $com_code, "id" => $request->id, 'is_archived' => 0, "finance_cln_periods_id" => $request->the_finance_cln_periods_id, 'main_salary_employee_id' => $request->main_salary_employee_id,));
            if (!empty($finance_cln_periods_data) and !empty($data_row) and !empty($main_salary_employee_data)) {
                destroy(new Main_salary_employee_absence(), array("com_code" => $com_code, "id" => $request->id, 'is_archived' => 0, "finance_cln_periods_id" => $request->the_finance_cln_periods_id, 'main_salary_employee_id' => $request->main_salary_employee_id,));
                return json_encode("done");
            }
        }
    }
    public function load_edit_row(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            alert("hi");
            $finance_cln_periods_data = get_cols_where_row(new Finance_cln_periods(), array("id"), array("com_code" => $com_code, "id" => $request->the_finance_cln_periods_id, 'is_open' => 1));
            $main_salary_employee_data  = get_cols_where_row(new Main_salary_employee(), array("id"), array("com_code" => $com_code, "finance_cln_periods_id" => $request->the_finance_cln_periods_id, 'id' => $request->main_salary_employee_id, 'is_archived' => 0));
            $data_row = get_cols_where_row(new Main_salary_employee_absence(), array("*"), array("com_code" => $com_code, "id" => $request->id, 'is_archived' => 0, "finance_cln_periods_id" => $request->the_finance_cln_periods_id, 'main_salary_employee_id' => $request->main_salary_employee_id,));
            $employees = Main_salary_employee::where("com_code","=",$com_code)->where("finance_cln_periods_id","=", $request->the_finance_cln_periods_id)->distinct()->get("employees_code");
            if(!empty($employees)){
                foreach($employees as $info){
                    $info->EmployeeData=get_cols_where_row(new employee(), array("emp_name", "emp_sal", "day_price", "zketo_code"),array("com_code"=>$com_code,"employees_code"=>$info->employees_code));
                }
            }

            return view('Main_salary_employee_absence.load_eddit_row', ['finance_cln_periods_data' => $finance_cln_periods_data, 'main_salary_employee_data' => $main_salary_employee_data, 'data_row' => $data_row, 'employees' => $employees]);
        }
    }
    public function do_edit_row(Request $request)
    {
        if ($request->ajax()) {
            $com_code = auth()->user()->com_code;
            $finance_cln_periods_data = get_cols_where_row(new Finance_cln_periods(), array("id"), array("com_code" => $com_code, "id" => $request->the_finance_cln_periods_id, 'is_open' => 1));
            $main_salary_employee_data  = get_cols_where_row(new Main_salary_employee(), array("*"), array("com_code" => $com_code, "finance_cln_periods_id" => $request->the_finance_cln_periods_id, 'employees_code' => $request->employees_code, 'is_archived' => 0));
            $data_row = get_cols_where_row(new Main_salary_employee_absence(), array("*"), array("com_code" => $com_code, "id" => $request->id, 'is_archived' => 0, "finance_cln_periods_id" => $request->the_finance_cln_periods_id, 'main_salary_employee_id' => $request->main_salary_employee_id,));
            if (!empty($finance_cln_periods_data) and !empty($main_salary_employee_data) and !empty($data_row)) {
                DB::beginTransaction();
                $dataToUpdate['employees_code'] = $request->employees_code;
                $dataToUpdate['emp_day_price'] = $request->emp_day_price;
                $dataToUpdate['value'] = $request->value;
                $dataToUpdate['total'] = $request->total;
                $dataToUpdate['notes'] = $request->notes;
                $dataToUpdate['updated_by'] = auth()->user()->id;
                update(new Main_salary_employee_absence(), $dataToUpdate, array("com_code" => $com_code, "id" => $request->id, 'is_archived' => 0, "finance_cln_periods_id" => $request->the_finance_cln_periods_id, 'main_salary_employee_id' => $request->main_salary_employee_id,));
                DB::commit();
                return json_encode("update");
            }
        }
    }
    
    public function print_search(Request $request)
    {
       
            $employees_code = $request->employees_code_search;
            $is_archived = $request->is_archived_search;
            $the_finance_cln_periods_id = $request->the_finance_cln_periods_id;

            if ($employees_code == 'all') {
                //هنا نعمل شرط دائم التحقق
                $field1 = "id";
                $operator1 = ">";
                $value1 = 0;
            } else {
                $field1 = "employees_code";
                $operator1 = "=";
                $value1 = $employees_code;
            }

            if ($is_archived == 'all') {
                //هنا نعمل شرط دائم التحقق
                $field2 = "id";
                $operator2 = ">";
                $value2 = 0;
            } else {
                $field2 = "is_archived";
                $operator2 = "=";
                $value2 = $is_archived;
            }
            $com_code = auth()->user()->com_code;
            $other['value_sum']=0;
            $other['total_sum']=0;
            $finance_cln_periods_data = get_cols_where_row(new Finance_cln_periods(), array("*"), array("com_code" => $com_code, "id" => $the_finance_cln_periods_id));
            $data = Main_salary_employee_absence::select("*")->where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where('finance_cln_periods_id', '=', $the_finance_cln_periods_id)->where('com_code', '=', $com_code)->orderby('id', 'DESC')->get();
            if (!empty($data)) {
                foreach ($data as $info) {
                    $info->emp_name = get_field_value(new employee(), "emp_name", array("com_code" => $com_code, "employees_code" => $info->employees_code));
                    $info->zketo_code = get_field_value(new employee(), "zketo_code", array("com_code" => $com_code, "employees_code" => $info->employees_code));
                    $other['value_sum']+=$info->value;
                    $other['total_sum']+=$info->total;
                }
            }
            $systemData=get_cols_where_row(new Admin_panel_setting(),array('phones','address','image','company_name'),array("com_code"=>$com_code,));
            return view('admin.Main_salary_employee_absence.print_search', ['data' => $data,'finance_cln_periods_data'=>$finance_cln_periods_data,'systemData'=>$systemData,'other'=>$other]);
        }
}
