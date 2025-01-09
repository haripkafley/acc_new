<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReminderAgency extends Model
{
    use HasFactory;
    protected $table = 'action_reminder_agency';

    public function agency_name()
    {
        return $this->hasOne('App\Models\Complaint\agencyModel','agencyID','agency_id');
    }
}
