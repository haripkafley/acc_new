<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionList extends Model
{
    use HasFactory;
    protected $table = 'action_complaint_list';

    public function agency_detailss()
    {
        return $this->hasMany('App\Models\ActionAgency','id','action_id');
    }

    public function atr_details()
    {
        return $this->hasMany('App\Models\AtrDetails','action_id','id');
    }
}
