<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowCaseReturnWithdrawn extends Model
{
    use HasFactory;
    protected $table = 'follow_case_returned_withdrawn_dropped';


    public function case_details()
    {
        return $this->hasOne('App\Models\RegisteredCase','id','case_id');
    }
    
}
