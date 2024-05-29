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
        Schema::table('employeees', function (Blueprint $table) {
            $table->string("SocialnsuranceNumber",50)->nullable();
            $table->string("medicalinsuranceNumber",50)->nullable();
            $table->string("emp_Basic_stay_com",300)->nullable()->comment("عنوان اقامة الموظق في بلدة الام");
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
};
