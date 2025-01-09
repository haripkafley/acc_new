<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensitizationAtrPerson extends Model
{
    use HasFactory;
    protected $table = 'sensitization_action_taken';

    public function person_details()
    {
        return $this->hasOne('App\Models\Complaint\personModel','cid','cid_no');
    }
}
