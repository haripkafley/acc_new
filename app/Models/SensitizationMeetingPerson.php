<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensitizationMeetingPerson extends Model
{
    use HasFactory;
    protected $table = 'sensitization_atr_meeting_person';

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','member_id');
    }

    public function complaint_details()
    {
        return $this->hasOne('App\Models\SensitizationAtrDetails','id','atr_id');
    }
}
