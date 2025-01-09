<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CecComplaintRecommendation extends Model
{
    use HasFactory;
    protected $table = "cec_complaint_recommendation";
    public function offence_name()
    {
        return $this->hasOne('App\Models\Complaint\OffenceEvaluation','offence_id','offence_id');
    }
}
