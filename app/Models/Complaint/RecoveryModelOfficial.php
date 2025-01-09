<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryModelOfficial extends Model
{
    use HasFactory;

    protected $table = "recovery_official";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function monitory_details()
    {
        return $this->hasOne('App\Models\Complaint\RecoveryModel','id','recovery_id');
    }
}
