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
        Schema::create('admin_panel_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name',225);
            $table->tinyInteger('saysem_status')->default('1');
            $table->string('image',225)->nullable();
            $table->string('phones',250); 
            $table->string('address',225);
            $table->string('email',100);
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();   
            $table->integer('com_code');
            $table->decimal('after_miniute_calculate_delay',10,2)->default(0)->comment("بعد كام دقيقة يتم احتساب تاخير حضور");
            $table->decimal('after_miniute_calculate_early_departure',10,2)->default(0)->comment("بعد كام دقيقة يتم احتساب انصراف مبكر");
            $table->decimal('after_miniute_quarterday',10,2)->default(0)->comment("بعد كام دقيقة مجمعة يتم احتساب ربع يوم انصارف او حضور مبكر");
            $table->decimal('after_time_half_daycut',10,2)->default(0)->comment("بعد كام مرة تاخير او انصراف مبكر نخصم نص يوم");
            $table->decimal('after_time_allday_daycut',10,2)->default(0)->comment("بعد كام مرة تاخير او انصراف مبكر نخصم يوم كامل");
            $table->decimal('monthly_vacation_balance',10,2)->default(0)->comment("رصيد اجازات الموظف الشهري");
            $table->decimal('after_days_begin_vacation',10,2)->default(0)->comment("بعد كام يوم ينزل للموطف رصيد اجازات");
            $table->decimal('first_balance_begin_vacation',10,2)->default(0)->comment("الرصيد الاولي للموظف بعد 6 اشهر حوالي 10 ايم ونصف");
            $table->decimal('sanctions_value_first_abcence',10,2)->default(0)->comment("قيمة خصم الايم يعد اول مرة غياب بدون اذن");
            $table->decimal('sanctions_value_second_abcence',10,2)->default(0)->comment("قيمة خصم الايم يعد ثاني مرة غياب بدون اذن");
            $table->decimal('sanctions_value_thaird_abcence',10,2)->default(0)->comment("قيمة خصم الايام يعد ثالث مرة غياب بدون اذن");
            $table->decimal('sanctions_value_forth_abcence',10,2)->default(0)->comment("قيمة خصم الايام يعد رابع مرة غياب بدون اذن");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_panel_settings');
    }
};
