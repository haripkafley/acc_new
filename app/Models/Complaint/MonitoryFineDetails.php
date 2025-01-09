<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoryFineDetails extends Model
{
    use HasFactory;
    protected $table = "monitory_fine_details";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
