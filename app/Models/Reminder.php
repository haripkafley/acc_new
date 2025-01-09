<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    protected $table = 'action_reminder';

    public function agency_details()
    {
        return $this->hasMany('App\Models\ReminderAgency','reminder_id','id');
    }
}
