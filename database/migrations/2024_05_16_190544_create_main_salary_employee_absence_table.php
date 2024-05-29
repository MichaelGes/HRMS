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
        Schema::create('main_salary_employee_absence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_salary_employee_id',)->references('id')->on('main_salary_employee')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('finance_cln_periods_id')->references('id')->on('finance_cln_periods')->onUpdate('cascade')->comment("كود الشهر المالي");
            $table->integer('is_auto')->nullable()->comment("هل تلقائي من النظام ام بشكل يدوي");
            $table->bigInteger('employees_code');
            $table->decimal('emp_day_price',10,2)->comment("اجر يوم الموظف");
            $table->decimal('value',10,2)->comment("كم يوم غياب");
            $table->decimal('total',10,2)->comment("اجمالي غياب");
            $table->integer('is_archived')->default(0)->comment("حالةالارشفة");
            $table->foreignId('archived_by')->nullable()->references('id')->on('admins')->onUpdate('cascade');
            $table->dateTime('archived_at')->nullable();
            $table->string('notes',100)->nullable();
            $table->foreignId('added_by')->references('id')->on('admins')->onUpdate('cascade');
            $table->foreignId('updated_by')->nullable()->references('id')->on('admins')->onUpdate('cascade');    
            $table->integer('active')->default(1);
            $table->integer('com_code'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_salary_employee_absence');
    }
};
