<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtrDetails extends Model
{
    use HasFactory;
    protected $table = 'atr_details';

    public function action_details()
    {
        return $this->hasOne('App\Models\ActionList','id','action_id');
    }
}
