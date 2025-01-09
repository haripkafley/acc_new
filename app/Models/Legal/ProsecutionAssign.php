<?php

namespace App\Models\Legal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsecutionAssign extends Model
{
    use HasFactory;
    protected $table = "legal_prosecution_assign";
    
    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
