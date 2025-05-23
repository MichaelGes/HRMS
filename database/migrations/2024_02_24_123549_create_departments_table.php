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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('phones',100);
            $table->string('notes',500)->nullable();
            $table->integer('added_by');
            $table->integer('updated_by')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
            $table->integer('com_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
