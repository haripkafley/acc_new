<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoryFineOfficial extends Model
{
    use HasFactory;

    protected $table = "monetary_official";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function monitory_details()
    {
        return $this->hasOne('App\Models\Complaint\MonitoryFine','id','monetary_id');
    }
}
