<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalOpinionOfficial extends Model
{
    use HasFactory;
    protected $table = "legal_opinion_official";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function legal_opinion_details()
    {
        return $this->hasOne('App\Models\Complaint\LegalOpinionModel','id','legal_id');
    }
}
