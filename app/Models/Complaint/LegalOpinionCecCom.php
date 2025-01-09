<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalOpinionCecCom extends Model
{
    use HasFactory;

    protected $table = "legal_opinion_cec_com";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','member_id');
    }

    public function legal_details()
    {
        return $this->hasOne('App\Models\Complaint\LegalOpinionModel','id','legal_id');
    }
}
