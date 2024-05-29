<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Additional_types extends Model
{
    use HasFactory;
    protected $table = "additional_types";
    protected $guarded=[];
    public function added(){
        return $this->belongsTo('\App\Models\Admin','added_by');
     }
     public function updatedby(){
        return $this->belongsTo('\App\Models\Admin','updated_by');
     }

}
