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
        Schema::table('main_salary_employee_sanctions', function (Blueprint $table) {
            $table->foreignId('finance_cln_periods_id')->references('id')->on('finance_cln_periods')->onUpdate('cascade')->comment("كود الشهر المالي");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_salary_employee_sanctions', function (Blueprint $table) {
            //
        });
    }
};
