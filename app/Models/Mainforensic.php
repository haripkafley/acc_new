<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mainforensic extends Model
{
    public $timestamps=false;
    protected $fillable = [
        'seizure_id', 
        'officername',
        'Instruction',
        'deadline',
        'item',
        'manufacturer',
        'serialNo',
        'condition',
        'model',
        'fid',
        'officersubstatus',
        'officerstatus',
        'finalstatus',
        'completionstatus',
        'startdate',
        'enddate'
        
    ];
}
