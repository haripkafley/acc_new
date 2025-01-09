<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherPrayers extends Model
{
    use HasFactory;
    protected $table = "other_prayers";

    public function probable_charge_details(){
        return $this->hasOne('App\Models\CaseProbableCharge','id','probable_charge_id');
    }
}
