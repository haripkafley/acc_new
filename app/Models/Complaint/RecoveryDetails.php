<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryDetails extends Model
{
    use HasFactory;

    protected $table = "recovery_model_details";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
