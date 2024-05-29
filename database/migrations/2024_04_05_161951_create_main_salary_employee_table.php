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
        Schema::create('main_salary_employee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finance_cln_periods_id')->references('id')->on('finance_cln_periods')->onUpdate('cascade')->comment("كود الشهر المالي");
            $table->integer('employees_code')->comment('كود الموظف');
            $table->string('emp_name',300)->comment("اسم الموظف لحظة فتح الراتب");
            $table->decimal('day_price',10,2)->comment(" قيمة يوم بالنسبة للراتب الموظف ")->default('0');
            $table->integer('is_Sensitive_manager_data')->nullable()->default('0')->comment("هل الموظف تابع الي الادارة العليا للطشف علي البيانات الحساسة");
            $table->integer('branch_id')->nullable()->comment('كود الفرع');
            $table->integer('Functiona_status')->comment("الحالة الوظفية");
            $table->integer('emp_Departments_code')->nullable()->comment("ادارة الوظف");
            $table->integer('emp_jobs_id')->nullable()->comment("نوع الوظيفة");
            $table->decimal('additions',10,2)->nullable()->comment("اجمالي الاضافي علي الراتب")->default('0');
            $table->decimal('Motivation',10,2)->nullable()->default('0')->comment("اجمالي الحافز علي الراتب");
            $table->decimal('additions_days_counter',10,2)->nullable()->default('0')->comment("اجمالي ايام الاضافي علي الراتب");
            $table->decimal('additions_days',10,2)->nullable()->default('0')->comment("اجمالي قيمة ايام الاضافي علي الراتب");
            $table->decimal('absence_days_counter',10,2)->comment("عدد ايام الغياب علي الراتب")->nullable()->default('0');
            $table->decimal('absence_days',10,2)->comment("اجمالي قيمة ايام الغياب علي الراتب")->nullable()->default('0');
            $table->decimal('monthly_loan',10,2)->comment("اجمالي قيمة مستقطع السلف الشهرية علي الراتب")->nullable()->default('0');
            $table->decimal('permanent_loan',10,2)->comment("اجمالي قيمة مستقطع السلف مستديمة علي الراتب")->nullable()->default('0');
            $table->decimal('discount',10,2)->comment("اجمالي قيمة الخصمات علي الراتب")->nullable()->default('0');
            $table->decimal('phones',10,2)->comment("اجمالي قيمة الخصم فاتورة التليفون علي الراتب")->nullable()->default('0');
            $table->decimal('medicalinsurancecutmonthelhy',10,2)->comment("اجمالي قيمة خصم ألتامين الطبي  علي الراتب")->nullable()->default('0');
            $table->decimal('socialnsurancecutmonthelhy',10,2)->comment("اجمالي قيمة خصم ألتامين الطبي  علي الراتب")->nullable()->default('0');
            $table->decimal('fixed_suits',10,2)->comment(" قيمة  ألبدالات الثابتة")->nullable()->default('0');
            $table->decimal('changable_suits',10,2)->comment(" قيمة ألبدالات المتغيرة للمرتب")->nullable()->default('0');
            $table->decimal('total_benefits',10,2)->comment("اجمالي الاستحقاقات")->nullable()->default('0');
            $table->decimal('total_deductions',10,2)->comment("اجمالي المتقطع")->nullable()->default('0');
            $table->decimal('Sanctions_days_counter_type1',10,2)->comment("اجمالي عدد ايام الجزاء")->nullable()->default('0');
            $table->decimal('Sanctions_days_total_type1',10,2)->comment("قيمة عدد ايام الجزاء")->nullable()->default('0');
            $table->decimal('Sanctions_days_counter_type2',10,2)->comment(" عدد ايام جزاء البصمة")->nullable()->default('0');
            $table->decimal('Sanctions_days_total_type2',10,2)->comment(" قيمة ايام جزاء البصمة")->nullable()->default('0');
            $table->decimal('Sanctions_days_counter_type3',10,2)->comment(" عدد ايام جزاء الغياب")->nullable()->default('0');
            $table->decimal('Sanctions_days_total_type3',10,2)->comment(" قيمة عدد ايام الجزاءالغياب")->nullable()->default('0');
            $table->decimal('Sanctions_days_total_type2_type1',10,2)->comment(" قيمة ايام الجزاء")->nullable()->default('0');
            $table->decimal('emp_sal',10,2)->comment(" قيمة مرتب الموظف")->nullable()->default('0');
            $table->decimal('last_salary_remain_blance',10,2)->comment(" قيمة مرتب المرحل من الشهر السابق ")->nullable()->default('0');
            $table->decimal('last_main_salary_record_id',10,2)->comment(" رقم الرتب للشهر السابق ")->nullable()->default('0');
            $table->decimal('final_the_net',10,2)->comment(" صافي قيمة الراتب ")->nullable()->default('0');
            $table->string('year_and_month',10)->comment("السنة + الشهر")->nullable()->default('0');
            $table->integer('FINANCE_YR')->comment("السنة المالية")->nullable()->default('0');
            $table->integer('sal_cach_or_visa')->comment("نوعية صرف الراتب")->nullable()->default('0');
            $table->integer('is_stoped')->comment("هل هذا الراتب موقوف")->nullable()->default('0');
            $table->integer('is_archived')->comment("هل مارشف")->nullable()->default('0');
            $table->dateTime('archived_date')->comment("تاريخ ارشفت الراتب")->nullable();
            $table->foreignId('archived_by')->nullable()->references('id')->on('admins')->onUpdate('cascade')->comment("من المستخدم الذي قام بعمل ارشيف");  
            $table->foreignId('added_by')->references('id')->on('admins')->onUpdate('cascade');
            $table->foreignId('updated_by')->nullable()->references('id')->on('admins')->onUpdate('cascade');  
            $table->integer('com_code')->comment("كود الشركة");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_salary_employee');
    }
};
