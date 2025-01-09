<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seziurewitness extends Model
{
    public $timestamps=false;
    protected $table = 'seizurewitnesses';

    protected $fillable = [
        'Id',	
        'SeizureId',
        'WitnessName',	
        'WitnessCid',
        'WitnessName1',	
        'WitnessCid1'
        
    ];
}
