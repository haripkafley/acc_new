<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CecComCrud extends Model
{
    use HasFactory;
    protected $table = "cec_com_user_crud";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
