<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensitizationReminder extends Model
{
    use HasFactory;
    protected $table = 'sensitization_action_reminder';

    public function agency_details()
    {
        return $this->hasMany('App\Models\SensitizationReminderAgency','reminder_id','id');
    }
}
