<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowConfiscation extends Model
{
    use HasFactory;
    protected $table = 'follow_confiscation';
    public function probable_charge_details(){
        return $this->hasOne('App\Models\FollowCharges','id','probable_charge_id');
    }
}
