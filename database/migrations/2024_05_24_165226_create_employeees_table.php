<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employeees', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_code')->comment('كود الموظف التلقائي لايتغير');
            $table->integer('zketo_code')->nullable()->comment('كود بصمة الموظف من جهاز البصمة لايتغير');
            $table->string("emp_name", 300);
            $table->integer('blood_group_id')->nullable();
            $table->foreignId('religion_id')->nullable()->comment('حقل الديانة')->references('id')->on('religions')->onUpdate('cascade');
            $table->string("staies_address", 300)->nullable()->comment("عنوان الاقامة الفعلي للموظف");
            $table->integer('children_number')->nullable()->default(0);
            $table->tinyInteger('emp_gender')->nullable()->comment("نوع الجنس  - واحد ذكر - اثنين انثي");
            $table->integer("emp_social_status_id")->nullable()->comment("الحالة الاجتماعية");
            $table->integer("emp_military_id")->nullable()->comment("الحالة العسكرية");
            $table->date("emp_military_date_from")->nullable()->comment("تاريخ بداية الخدمة العسكرية");
            $table->date("emp_military_date_to")->nullable()->comment("تاريخ نهاية الخدمة العسكرية");
            $table->string("emp_military_wepon")->nullable()->comment("نوع سلاح الخدمة العسكرية");
            $table->date("exemption_date")->nullable()->comment("تاريخ الاعفاء من الخدمه العسكرية");
            $table->string("exemption_reason", 300)->nullable()->comment("ٍبب الاعفاء من الخدمه العسكرية ");
            $table->tinyInteger("does_has_Driving_License")->nullable()->default(0)->comment("هل يمتلك رخصه قياده");
            $table->string("driving_License_degree", 50)->nullable()->comment("رقم رخصه القيادة");
            $table->foreignId("Qualifications_id")->nullable()->comment("المؤهل التعليمي")->references("id")->on("qualifications")->onUpdate("cascade");
            $table->string("Qualifications_year", 10)->nullable()->comment("سنة التخرج");
            $table->tinyInteger("graduation_estimate")->nullable()->comment("تقدير التخرج - واحد مقبول - اثنين جيد - ثلاثه جيد مرتفع - اربعه جيد جدا - خمسه امتياز");
            $table->string("Graduation_specialization", 225)->nullable()->comment("تخصص التخرج");
            $table->date("emp_start_date")->nullable()->comment("تاريخ بدء العمل للموظف");
            $table->tinyInteger("Functiona_status")->nullable()->default(0)->comment("حالة الموظف واحد يعمل - صفر خارج الخدمة");
            $table->foreignId("Resignations_id")->nullable()->references("id")->on("resignations")->onUpdate("cascade");
            $table->date("Date_resignation")->nullable()->comment("تاريخ ترك العمل");
            $table->string("resignation_cause")->nullable()->comment("سبب ترك العمل");
            $table->tinyInteger("MotivationType")->nullable()->default(0)->comment("صفر لايوجد - واحد ثابت - اثنين متغير");
            $table->decimal("Motivation", 10, 2)->nullable()->default(0)->comment("قيمة الحافز الثابت ان وجد");
            $table->tinyInteger("sal_cach_or_visa")->nullable()->default(1)->comment("نوع صرف الراتب - واحد كاش - اثنين فيزا بنكي");
            $table->string("bank_number_account", 50)->nullable()->comment("رقم حساب البنك للموظف");
            $table->tinyInteger("is_Disabilities_processes")->nullable()->default(0)->comment("هل له اعاقة  - واحد يوجد صفر لايوجد");
            $table->string("Disabilities_processes", 500)->nullable()->comment("نوع الاعاقة");
            $table->tinyInteger("has_Relatives")->nullable()->default(0)->comment("هل له اقارب بالعمل ");
            $table->string("Relatives_details", 600)->nullable()->comment("تفاصيل الاقارب بالعمل");
            $table->string("urgent_person_details", 600)->nullable()->comment("تفاصيل شخص يمكن الرجوع اليه للوصول للموظف");
            $table->decimal("daily_work_hour", 10, 2)->nullable()->comment("عدد ساعات العمل للموظف وهذا في حالة ان ليس له شفت ثابت");
            $table->foreignId("emp_jobs_id")->nullable()->references("id")->on("jobs_categories")->onUpdate("cascade");
            $table->foreignId("emp_nationality_id")->nullable()->references("id")->on("nationalities")->onUpdate("cascade");
            $table->string("emp_national_idenity", 50)->nullable()->comment("رقم البطاقة الشخصية - او رقم الهوية");
            $table->date("emp_end_identityIDate")->nullable()->comment("تاريخ نهاية البطاقة الشخصية - بطاقة الهوية");
            $table->string("emp_identityPlace", 225)->nullable()->comment("مكان اصدار بطاقة الهوية الشخصية");
            $table->foreignId("emp_Departments_code")->nullable()->references("id")->on("departments")->onUpdate("cascade");
            $table->string("emp_cafel")->nullable()->comment("اسم الكفيل ");
            $table->string("emp_pasport_no", 100)->nullable()->comment("رقم الباسبور ان وجد");
            $table->string("emp_pasport_from", 100)->nullable()->comment("مكان استخراج الباسبور");
            $table->date("emp_pasport_exp")->nullable()->comment("تاريخ انتهاء الباسبور");
            $table->string("emp_home_tel", 50)->nullable()->comment("رقم هاتف المنزل");
            $table->string("emp_work_tel", 50)->nullable()->comment("رقم هاتف العمل");
            $table->string("emp_email", 100)->nullable()->comment(" ايميل  الموظف");
            $table->string("emp_photo", 100)->nullable()->comment(" صورة  الموظف");
            $table->decimal("emp_sal", 10, 2)->nullable()->default(0)->comment("راتب الموظف");
            $table->integer("emp_lang_id")->nullable()->comment(" اللغه التي يتكلم بها الاساسية");
            $table->date("brith_date")->nullable()->comment("تاريخ ميلاد الموظف");
            $table->integer("country_id")->nullable()->comment("دولة الموظف");
            $table->integer("governorate_id")->nullable()->comment("محافظة الموظف");
            $table->integer("city_id")->nullable()->comment("مدينة الموظف");
            $table->date("date")->nullable();
            $table->foreignId("added_by")->references("id")->on("admins")->onUpdate("cascade");
            $table->foreignId("updated_by")->nullable()->references("id")->on("admins")->onUpdate("cascade");
            $table->integer("com_code");
            $table->tinyInteger("is_has_fixced_shift")->nullable()->comment("هل للموظف شفت ثابت");
            $table->foreignId("shift_type_id")->nullable()->references("id")->on("shifts_types")->onUpdate("cascade");
            $table->decimal("day_price", 10, 2)->nullable()->comment("سعر يوم الموظف");
            $table->tinyInteger("isSocialnsurance")->nullable()->default(0)->comment("هل للموظف تأمين اجتماعي");
            $table->decimal("Socialnsurancecutmonthely", 10, 2)->nullable()->comment("  قيمة استقطاع التأمين الاجتماعي الشهري للموظف");
            $table->tinyInteger("ismedicalinsurance")->nullable()->default(0)->comment("هل للموظف تأمين طبي");
            $table->decimal("medicalinsurancecutmonthely", 10, 2)->nullable()->comment("  قيمة استقطاع التأمين الطبي الشهري للموظف");
            $table->tinyInteger("Does_have_fixed_allowances")->nullable()->default(0)->comment("هل له بدلات ثابته");
            $table->tinyInteger("does_has_ateendance")->nullable()->default(1)->comment("هل ملزم الموظف بعمل بصمه حضور وانصراف");
            $table->tinyInteger("is_done_Vaccation_formula")->nullable()->default(0)->comment("هل تمت المعادله التلقائية لاحتساب الرصيد السنوي للموظف");
            $table->tinyInteger("is_active_for_Vaccation")->nullable()->default(0)->comment("هل هذا الموظف ينزل له رصيد اجازات	");
            $table->tinyInteger("is_Sensitive_manager_data")->nullable()->default(0)->comment("هل بيانات حساساه للمديرين مثلا ولاتظهر الا بصلاحيات خاصة	");
            $table->integer("branch_id")->nullable()->default(1)->comment("الفرع التابع له الموظف ");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employeees');
    }
};
