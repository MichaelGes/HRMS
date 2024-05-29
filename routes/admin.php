<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Admin_panel_settingController;
use App\Http\Controllers\Admin\Finance_calendersController;
use App\Http\Controllers\Admin\BranchesController;
use App\Http\Controllers\Admin\ShiftsTypesController;
use App\Http\Controllers\Admin\DepartmentsController;
use App\Http\Controllers\Admin\Jobs_categoriesController;
use App\Http\Controllers\Admin\QualificationsController;
use App\Http\Controllers\Admin\OccasionsController;
use App\Http\Controllers\Admin\ResignationsController;
use App\Http\Controllers\Admin\NationalitiesController;
use App\Http\Controllers\Admin\ReligionsController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\AdditionalTypesController;
use App\Http\Controllers\Admin\DiscountTypesController;
use App\Http\Controllers\Admin\AllowancesController;
use App\Http\Controllers\Admin\MainSalaryRecord;
use App\Http\Controllers\Admin\Main_salary_employee_sanctions;
use App\Http\Controllers\Admin\Main_salary_employee_absenceController;




use GuzzleHttp\Middleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

define('PC', 5);
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    /* بداية الضبط العام */
    Route::get('/generalSettings', [Admin_panel_settingController::class, 'index'])->name('admin_panel_settings.index');
    Route::get('/generalSettingsEdit', [Admin_panel_settingController::class, 'edit'])->name('admin_panel_settings.edit');
    Route::post('/generalSettingsupdate', [Admin_panel_settingController::class, 'update'])->name('admin_panel_settings.update');
    /* انهاء الضبط العام */
    /******************************************************************************************************* */
    /* Start-finance-years */
    Route::get('/finance_calender/delete/{id}', [Finance_calendersController::class, 'destroy'])->name('finance_calender.delete');
    Route::post('/finance_calender/show_year_monthes', [Finance_calendersController::class, 'show_year_monthes'])->name('finance_calender.show_year_monthes');
    Route::get('/finance_calender/do_open/{id}', [Finance_calendersController::class, 'do_open'])->name('finance_calender.do_open');
    Route::resource('/finance_calender', Finance_calendersController::class);
    /* End-finance-years */
    /* Start-branch */
    Route::get("/branches", [BranchesController::class, 'index'])->name('branches.index');
    Route::get("/branchesCreate", [BranchesController::class, 'create'])->name('branches.create');
    Route::post("/branchesStore", [BranchesController::class, 'Store'])->name('branches.Store');
    Route::get("/branchesEdit/{id}", [BranchesController::class, 'Edit'])->name('branches.Edit');
    Route::post("/branchesUpdate/{id}", [BranchesController::class, 'Update'])->name('branches.Update');
    Route::get("/branchesDelete/{id}", [BranchesController::class, 'destroy'])->name('branches.destroy');
    /* End-branch */

    /* Start-Shift */
    Route::get("/SheftsTypes", [ShiftsTypesController::class, 'index'])->name('SheftsTypes.index');
    Route::get("/SheftsTypesCreate", [ShiftsTypesController::class, 'Create'])->name('SheftsTypes.Create');
    Route::post("/SheftsTypesStore", [ShiftsTypesController::class, 'Store'])->name('SheftsTypes.Store');
    Route::get("/SheftsTypesEdit/{id}", [ShiftsTypesController::class, 'edit'])->name('SheftsTypes.edit');
    Route::post("/SheftsTypesUpdate/{id}", [ShiftsTypesController::class, 'update'])->name('SheftsTypes.update');
    Route::get("/SheftsTypesDestroy/{id}", [ShiftsTypesController::class, 'destroy'])->name('SheftsTypes.destroy');
    Route::post("/SheftsTypesajax_search/", [ShiftsTypesController::class, 'ajax_search'])->name('SheftsTypes.ajax_search');
    /* End-Shift */

    /* Start-Department */
    Route::get('/departments', [DepartmentsController::class, 'index'])->name('departments.index');
    Route::get('/departmentsCreate', [DepartmentsController::class, 'create'])->name('departments.create');
    Route::post('/departmentsStore', [DepartmentsController::class, 'store'])->name('departments.store');
    Route::get('/departmentsEdit/{id}', [DepartmentsController::class, 'edit'])->name('departments.edit');
    Route::post('/departmentsUpdate/{id}', [DepartmentsController::class, 'update'])->name('departments.update');
    Route::get('/departmentsDestroy/{id}', [DepartmentsController::class, 'destroy'])->name('departments.destroy');
    /* End-Department */

    /* Start-Job-cate */
    Route::get('/jobs_categories', [Jobs_categoriesController::class, 'index'])->name('jobs_categories.index');
    Route::get('/jobs_categoriesCreate', [Jobs_categoriesController::class, 'create'])->name('jobs_categories.create');
    Route::post('/jobs_categoriesStore', [Jobs_categoriesController::class, 'store'])->name('jobs_categories.store');
    Route::get('/jobs_categoriesEdit/{id}', [Jobs_categoriesController::class, 'edit'])->name('jobs_categories.edit');
    Route::post('/jobs_categoriesUpdate/{id}', [Jobs_categoriesController::class, 'update'])->name('jobs_categories.update');
    Route::get('/jobs_categoriesDestroy/{id}', [Jobs_categoriesController::class, 'destroy'])->name('jobs_categories.destroy');
    /* End-Job-cate */

    /* Start-Qualifications */
    Route::get('/Qualifications', [QualificationsController::class, 'index'])->name('Qualifications.index');
    Route::get('/QualificationsCreate', [QualificationsController::class, 'create'])->name('Qualifications.create');
    Route::post('/QualificationsStore', [QualificationsController::class, 'store'])->name('Qualifications.store');
    Route::get('/QualificationsEdit/{id}', [QualificationsController::class, 'edit'])->name('Qualifications.edit');
    Route::post('/QualificationsUpdate/{id}', [QualificationsController::class, 'update'])->name('Qualifications.update');
    Route::get('/QualificationsDestroy/{id}', [QualificationsController::class, 'destroy'])->name('Qualifications.destroy');
    /* End-Qualifications */

    /* Start-OccasionsController */
    Route::get('/occasions', [OccasionsController::class, 'index'])->name('occasions.index');
    Route::get('/occasionsCreate', [OccasionsController::class, 'create'])->name('occasions.create');
    Route::post('/occasionsStore', [OccasionsController::class, 'store'])->name('occasions.store');
    Route::get('/occasionsEdit/{id}', [OccasionsController::class, 'edit'])->name('occasions.edit');
    Route::post('/occasionsUpdate/{id}', [OccasionsController::class, 'update'])->name('occasions.update');
    Route::get('/occasionsDestroy/{id}', [OccasionsController::class, 'destroy'])->name('occasions.destroy');
    /* End-OccasionsController */

    /* Start-ResignationsController */
    Route::get('/Resignations', [ResignationsController::class, 'index'])->name('Resignations.index');
    Route::get('/ResignationsCreate', [ResignationsController::class, 'create'])->name('Resignations.create');
    Route::post('/ResignationsStore', [ResignationsController::class, 'store'])->name('Resignations.store');
    Route::get('/ResignationsEdit/{id}', [ResignationsController::class, 'edit'])->name('Resignations.edit');
    Route::post('/ResignationsUpdate/{id}', [ResignationsController::class, 'update'])->name('Resignations.update');
    Route::get('/ResignationsDestroy/{id}', [ResignationsController::class, 'destroy'])->name('Resignations.destroy');
    /* End-ResignationsController */
    
    /* Start-Nationalities */
    Route::get('/Nationalities', [NationalitiesController::class, 'index'])->name('Nationalities.index');
    Route::get('/NationalitiesCreate', [NationalitiesController::class, 'create'])->name('Nationalities.create');
    Route::post('/NationalitiesStore', [NationalitiesController::class, 'store'])->name('Nationalities.store');
    Route::get('/NationalitiesEdit/{id}', [NationalitiesController::class, 'edit'])->name('Nationalities.edit');
    Route::post('/NationalitiesUpdate/{id}', [NationalitiesController::class, 'update'])->name('Nationalities.update');
    Route::get('/NationalitiesDestroy/{id}', [NationalitiesController::class, 'destroy'])->name('Nationalities.destroy');
    /* End-Nationalities */

    /* Start-Religion */
    Route::get('/Religion', [ReligionsController::class, 'index'])->name('Religion.index');
    Route::get('/ReligionCreate', [ReligionsController::class, 'create'])->name('Religion.create');
    Route::post('/ReligionStore', [ReligionsController::class, 'store'])->name('Religion.store');
    Route::get('/ReligionEdit/{id}', [ReligionsController::class, 'edit'])->name('Religion.edit');
    Route::post('/ReligionUpdate/{id}', [ReligionsController::class, 'update'])->name('Religion.update');
    Route::get('/ReligionDestroy/{id}', [ReligionsController::class, 'destroy'])->name('Religion.destroy');
    /* End-Religion */

    /* Start-Additional */
    Route::get('/AdditionalTypes', [AdditionalTypesController::class, 'index'])->name('AdditionalTypes.index');
    Route::get('/AdditionalTypesCreate', [AdditionalTypesController::class, 'create'])->name('AdditionalTypes.create');
    Route::post('/AdditionalTypesStore', [AdditionalTypesController::class, 'store'])->name('AdditionalTypes.store');
    Route::get('/AdditionalTypesEdit/{id}', [AdditionalTypesController::class, 'edit'])->name('AdditionalTypes.edit');
    Route::post('/AdditionalTypesUpdate/{id}', [AdditionalTypesController::class, 'update'])->name('AdditionalTypes.update');
    Route::get('/AdditionalTypesDestroy/{id}', [AdditionalTypesController::class, 'destroy'])->name('AdditionalTypes.destroy');
    /* End-Additional */
    /* Start-Discount */
    Route::get('/Discount', [DiscountTypesController::class, 'index'])->name('DiscountTypes.index');
    Route::get('/DiscountTypesCreate', [DiscountTypesController::class, 'create'])->name('DiscountTypes.create');
    Route::post('/DiscountTypesStore', [DiscountTypesController::class, 'store'])->name('DiscountTypes.store');
    Route::get('/DiscountTypesEdit/{id}', [DiscountTypesController::class, 'edit'])->name('DiscountTypes.edit');
    Route::post('/DiscountTypesUpdate/{id}', [DiscountTypesController::class, 'update'])->name('DiscountTypes.update');
    Route::get('/DiscountTypesDestroy/{id}', [DiscountTypesController::class, 'destroy'])->name('DiscountTypes.destroy');
    /* End-Descount */

    /* Start-Allowances */
    Route::get('/Allowances', [AllowancesController::class, 'index'])->name('Allowances.index');
    Route::post('/AllowancesTypesStore', [AllowancesController::class, 'store'])->name('Allowances.store');
    Route::get('/AllowancesTypesEdit/{id}', [AllowancesController::class, 'edit'])->name('Allowances.edit');
    Route::post('/AllowancesTypesUpdate/{id}', [AllowancesController::class, 'update'])->name('Allowances.update');
    Route::get('/AllowancesTypesDestroy/{id}', [AllowancesController::class, 'destroy'])->name('Allowances.destroy');
    Route::get('/AllowancesTypesCreate', [AllowancesController::class, 'create'])->name('AllowancesTypesCreate.create');
    /* End-Allowances */

    /* Start-Main-salary_Record */
    Route::get('/MainSalaryRecord/index', [MainSalaryRecord::class, 'index'])->name('MainSalaryRecord.index');
    Route::post('/MainSalaryRecord/do_open_month/{id}', [MainSalaryRecord::class, 'do_open_month'])->name('MainSalaryRecord.do_open_month');
    Route::post('/MainSalaryRecord/Store', [MainSalaryRecord::class, 'store'])->name('MainSalaryRecord.store');
    Route::get('/MainSalaryRecord/Edit/{id}', [MainSalaryRecord::class, 'edit'])->name('MainSalaryRecord.edit');
    Route::post('/MainSalaryRecord/Update/{id}', [MainSalaryRecord::class, 'update'])->name('MainSalaryRecord.update');
    Route::get('/MainSalaryRecord/Destroy/{id}', [MainSalaryRecord::class, 'destroy'])->name('MainSalaryRecord.destroy');
    Route::post('/MainSalaryRecord/load_open_month', [MainSalaryRecord::class, 'load_open_month'])->name('MainSalaryRecord.load_open_month');
    /* End-Main-salary_Record */

    /* Start-Main-salary_sanctions */
    Route::get('/MainSalaryEmployeeSanctions/index', [Main_salary_employee_sanctions::class, 'index'])->name('MainSalaryEmployeeSanctions.index');
    Route::get('/MainSalaryEmployeeSanctions/show/{id}', [Main_salary_employee_sanctions::class, 'show'])->name('MainSalaryEmployeeSanctions.show');
    Route::post('/MainSalaryEmployeeSanctions/checkExsistsBefor', [Main_salary_employee_sanctions::class, 'checkExsistsBefor'])->name('MainSalaryEmployeeSanctions.checkExsistsBefor');
    Route::post('/MainSalaryEmployeeSanctions/store', [Main_salary_employee_sanctions::class, 'store'])->name('MainSalaryEmployeeSanctions.store');
    Route::post('/MainSalaryEmployeeSanctions/ajax_search', [Main_salary_employee_sanctions::class, 'ajax_search'])->name('MainSalaryEmployeeSanctions.ajax_search');
    Route::post('/MainSalaryEmployeeSanctions/delete_row', [Main_salary_employee_sanctions::class, 'delete_row'])->name('MainSalaryEmployeeSanctions.delete_row');
    Route::post('/MainSalaryEmployeeSanctions/load_edit_row', [Main_salary_employee_sanctions::class, 'load_edit_row'])->name('MainSalaryEmployeeSanctions.load_edit_row');
    Route::post('/MainSalaryEmployeeSanctions/do_edit_row', [Main_salary_employee_sanctions::class, 'do_edit_row'])->name('MainSalaryEmployeeSanctions.do_edit_row');
    Route::post('/MainSalaryEmployeeSanctions/print_search', [Main_salary_employee_sanctions::class, 'print_search'])->name('MainSalaryEmployeeSanctions.print_search');

    /* End-Main-salary_sanctions */
/* Start-EMP */
Route::get('/Employees', [EmployeesController::class, 'index'])->name('Employees.index');
Route::get('/Employees/Create', [EmployeesController::class, 'create'])->name('Employees.create');
Route::post('/Employees/Store', [EmployeesController::class, 'store'])->name('Employees.store');
Route::get('/Employees/Edit/{id}', [EmployeesController::class, 'edit'])->name('Employees.edit');
Route::post('/Employees/Update/{id}', [EmployeesController::class, 'update'])->name('Employees.update');
Route::get('/Employees/Destroy/{id}', [EmployeesController::class, 'destroy'])->name('Employees.destroy');
Route::post("/Employees/get_governorates", [EmployeesController::class, 'get_governorates'])->name('Employees.get_governorates');
Route::post("/Employees/get_centers", [EmployeesController::class, 'get_centers'])->name('Employees.get_centers');
Route::get('/Employees/show/{id}', [EmployeesController::class, 'show'])->name('Employees.show');
Route::post('/Employees/ajax_search', [EmployeesController::class, 'ajax_search'])->name('Employees.ajax_search');
Route::get('/Employees/download/{id}/{field_name}', [EmployeesController::class, 'download'])->name('Employees.download');
Route::post('/Employees/add_files/{id}', [EmployeesController::class, 'add_files'])->name('Employees.add_files');
Route::get('/Employees/download_files/{id}', [EmployeesController::class, 'download_files'])->name('Employees.download_files');
Route::get('/Employees/destroy_files/{id}', [EmployeesController::class, 'destroy_files'])->name('Employees.destroy_files');
/* End-EMP */


    
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
    Route::get('login', [LoginController::class, 'show_login_view'])->name('admin.showlogin');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
});
Route::fallback(function () {
    return redirect()->route('admin.showlogin');
});
