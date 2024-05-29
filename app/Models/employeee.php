<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employeee extends Model
{
    use HasFactory;
    protected $table="employeees";
    protected $guarded = [];
    public function added(){
        return $this->belongsTo('\App\Models\Admin','added_by');
     }
     public function updatedby(){
        return $this->belongsTo('\App\Models\Admin','updated_by');
     }
     public function Branch(){
      return $this->belongsTo('\App\Models\Branche','branch_id');
   }
   public function Departments(){
      return $this->belongsTo('\App\Models\Departments','emp_Departments_code');
   }
   public function jobs(){
      return $this->belongsTo('\App\Models\jobs_categorie','emp_jobs_id');
   }
}
