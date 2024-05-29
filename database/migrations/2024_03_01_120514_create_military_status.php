<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('military_status', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->tinyInteger('active')->default(1);
  
        });

        DB::table('military_status')->insert(
            [
                ['name'=>'ادي الخدمة',
                 'active'=>1,
           
            ],
            ['name'=>'تاجيل',
                 'active'=>1,
              
            ],
            ['name'=>'اعفاء نهائي',
            'active'=>1,
       
           ],
           ['name'=>'لم يصبة الدور',
           'active'=>1,
   
          ],

            ]
        );
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('military_status');
    }
};
