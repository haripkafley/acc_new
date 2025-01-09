<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionAgency extends Model
{
    use HasFactory;
    protected $table = 'action_taken_agency';

    public function agency_name()
    {
        return $this->hasOne('App\Models\Complaint\agencyModel','agency_id','agencyID');
    }
}
