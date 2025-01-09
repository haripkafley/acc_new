<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensitizationActionList extends Model
{
    use HasFactory;
    protected $table = 'sensitization_action_complaint_list';

    public function agency_detailss()
    {
        return $this->hasMany('App\Models\ActionAgency','id','action_id');
    }

    public function atr_details()
    {
        return $this->hasMany('App\Models\SensitizationAtrDetails','action_id','id');
    }
}
