<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompalintEveOffence extends Model
{
    use HasFactory;
    protected $table = "complaint_eva_offence";
    public function offence_name()
    {
        return $this->hasOne('App\Models\Complaint\OffenceEvaluation','offence_id','offence_id');
    }

    public function cec_recommendation()
    {
        return $this->hasOne('App\Models\Complaint\CecComplaintRecommendation','selected_offence_id','id');
    }

    public function complaint_details()
    {
        return $this->hasOne('App\Models\Complaint\complaintRegistrationModel','complaintID','complaint_id');
    }

    public function appraise_details()
    {
        return $this->hasOne('App\Models\Appraise','eve_offence_id','id');
    }
}
