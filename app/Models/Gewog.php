<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gewog extends Model
{
    use HasFactory;
    protected $table='pl_tblgewog';
    protected $primaryKey = 'gewogID';

    public function getDzongkhagDetails(){
        return $this->hasOne('App\Models\Dzongkhag', 'dzoID', 'dzoID');
    }
}
