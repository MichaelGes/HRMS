<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Finance_calender;
use App\Models\Finance_cln_periods;
use App\Models\employee;
use App\Models\Main_salary_employee;




class MainSalaryRecord extends Controller
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
                // get_count_where(new Finance_cln_periods(),array("com_code"=>$com_code,"is_open"=>0,"FINANCE_YR"=>$info->FINANCE_YR,'MONTH_ID'));

            }
        }
        return view('admin.MainSalaryRecord.index', ['data' => $data]);
    }
    public function do_open_month($id, Request $request)
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row(new Finance_cln_periods(), array("*"), array("com_code" => $com_code, "id" => $id));

        if (empty($data)) {
            return redirect()->route('MainSalaryRecord.index')->with(['error' => 'عفوا فير قادر الي الوصل للبيانات المطلوبة']);
        }
        $currentYear = get_cols_where_row(new Finance_calender(), array("is_open"), array("com_code" => $com_code, "FINANCE_YR" => $data['FINANCE_YR']));
        if (empty($currentYear)) {
            return redirect()->route('MainSalaryRecord.index')->with(['error' => 'عفوا فير قادر الي الوصل بيانات السنة المالية المطلوبة']);
        }
        if ($currentYear['is_open'] != 1) {
            return redirect()->route('MainSalaryRecord.index')->with(['error' => 'عفوا السنة المالية التابعى لهذا الشهر غير مفتوحةالان']);
        }
        if ($data['is_open'] == 1) {
            return redirect()->route('MainSalaryRecord.index')->with(['error' => 'عفوا هذا الشهر مفتوح حاليا']);
        }
        if ($data['is_open'] == 2) {
            return redirect()->route('MainSalaryRecord.index')->with(['error' => 'عفوا هذا الشهر مؤرشف من قبل ']);
        }
        $counterOpenMonth = get_count_where(new Finance_cln_periods(), array("com_code" => $com_code, "is_open" => 1));
        if ($counterOpenMonth > 0) {
            return redirect()->route('MainSalaryRecord.index')->with(['error' => 'عفوا لايمكن فتح هذا الشهر المالي لوجود شهر اخر مفتوح حالياً ']);
        }
        $counterPreviousMonthWatingOpen = Finance_cln_periods::where("com_code", "=", $com_code)
            ->where("FINANCE_YR", "=", $data['FINANCE_YR'])
            ->where("MONTH_ID", "<", $data['MONTH_ID'])
            ->where("is_open", "=", 0)->count();
        if ($counterOpenMonth > 0) {
            return redirect()->route('MainSalaryRecord.index')->with(['error' => 'عفوا لايمكن فتح هذا الشهر المالي لوجود شهر اخر سابق لة يجب فتحة اولا ']);
        }
        $dataToUpdate['start_date_for_pasma'] = $request->start_date_for_pasma;
        $dataToUpdate['end_date_for_pasma'] = $request->end_date_for_pasma;
        $dataToUpdate['is_open'] = 1;
        $dataToUpdate['updated_by'] = auth()->user()->id;
        $dataToUpdate['updated_at'] = date("Y-m-d H:i:s");
        $flag = update(new Finance_cln_periods(), $dataToUpdate, array("com_code" => $com_code, "id" => $id, 'is_open' => 0));
        // code to open salary to emp
        if ($flag) {
            $allemployees = get_cols_where(new employee(), array("*"), array("com_code" => $com_code, "Functiona_status" => 1), 'employees_code', 'ASC');
            if (!empty($allemployees)) {
                foreach ($allemployees as $info) {
                    $DataSalaryToinsert = array();
                    $DataSalaryToinsert['finance_cln_periods_id'] = $id;
                    $DataSalaryToinsert['employees_code'] = $info->employees_code;
                    $DataSalaryToinsert['com_code'] = $com_code;
                    $checkExsistsCounter = get_count_where(new Main_salary_employee(), $DataSalaryToinsert);
                    if ($checkExsistsCounter == 0) {
                        $DataSalaryToinsert['emp_name'] = $info->emp_name;
                        $DataSalaryToinsert['day_price'] = $info->day_price;
                        $DataSalaryToinsert['is_Sensitive_manager_data'] = $info->is_Sensitive_manager_data;
                        $DataSalaryToinsert['branch_id'] = $info->branch_id;
                        $DataSalaryToinsert['Functiona_status'] = $info->Functiona_status;
                        $DataSalaryToinsert['emp_Departments_code'] = $info->Functiona_status;
                        $DataSalaryToinsert['emp_jobs_id'] = $info->emp_jobs_id;
                        $DataSalaryToinsert['last_salary_remain_blance'] = 0;
                        $DataSalaryToinsert['emp_sal'] = $info->emp_sal;
                        $DataSalaryToinsert['year_and_month'] = $data['year_and_month'];
                        $DataSalaryToinsert['FINANCE_YR'] = $data['FINANCE_YR'];
                        $DataSalaryToinsert['sal_cach_or_visa'] = $info->sal_cach_or_visa;
                        $DataSalaryToinsert['added_by'] = auth()->user()->id;
                        insert(new Main_salary_employee(), $DataSalaryToinsert);
                    }
                }
            }
        }
        return redirect()->route('MainSalaryRecord.index')->with(['success' => 'تم فتح الشهر المالي بنجاح']);
    }
    public function load_open_month(request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $com_code = auth()->user()->com_code;
            $data = get_cols_where_row(new Finance_cln_periods(), array("*"), array("com_code" => $com_code, "id" => $id));
            return view('admin.MainSalaryRecord.load_open_month', ['data' => $data]);
        }
    }
}
