<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiscationPrayed extends Model
{
    use HasFactory;
    protected $table = "confiscation_prayed";

    public function probable_charge_details(){
        return $this->hasOne('App\Models\CaseProbableCharge','id','probable_charge_id');
    }
}
