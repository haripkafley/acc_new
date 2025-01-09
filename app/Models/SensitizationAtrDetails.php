<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensitizationAtrDetails extends Model
{
    use HasFactory;
    protected $table = 'sensitization_atr_details';

    public function action_details()
    {
        return $this->hasOne('App\Models\SensitizationActionList','id','action_id');
    }
}
