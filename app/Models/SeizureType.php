<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeizureType extends Model
{
    use HasFactory;
    protected $table = 'tbl_seizuretypes_lookup';
    public $timestamps = true;

    protected $fillable = [
        'seizure_type',
    ];
}
