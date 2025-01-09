<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInquiryRoom extends Model
{
    use HasFactory;
    protected $table = "administrative_inquiry_com_room";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','member_id');
    }

    public function appraise_details()
    {
        return $this->hasOne('App\Models\Appraise','id','appraise_id');
    }
}
