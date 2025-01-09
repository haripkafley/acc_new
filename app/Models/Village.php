<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $table='pl_tblvillage';
    protected $primaryKey = 'villageID';

    public function getGewogDetails(){
        return $this->hasOne('App\Models\Gewog', 'gewogID', 'gewogID');
    }

    public function getDzongkhagDetails(){
        return $this->hasOne('App\Models\Dzongkhag', 'dzoID', 'dzoID');
    }
}
