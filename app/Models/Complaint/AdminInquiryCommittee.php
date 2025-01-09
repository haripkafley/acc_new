<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInquiryCommittee extends Model
{
    use HasFactory;
    protected $table = "administrative_inquiry_committe";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
