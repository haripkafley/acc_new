<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationMeetingPerson extends Model
{
    use HasFactory;
    protected $table = 'evaluation_meeting_person';

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','member_id');
    }

    public function complaint_details()
    {
        return $this->hasOne('App\Models\Complaint\complaintRegistrationModel','complaintID','complaint_id');
    }
}
