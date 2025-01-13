<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryCecCom extends Model
{
    use HasFactory;

    protected $table = "recovery_cec_com";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','member_id');
    }

    public function monitory_details()
    {
        return $this->hasOne('App\Models\Complaint\RecoveryModel','id','recovery_id');
    }
}
