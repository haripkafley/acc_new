<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IgComplaintCecCom extends Model
{
    use HasFactory;
    protected $table = "information_gathering_complaint_cec_com";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','member_id');
    }

    public function ig_complaint_details()
    {
        return $this->hasOne('App\Models\Complaint\InformationGatheringComplaint','id','ig_complaint_id');
    }
}
