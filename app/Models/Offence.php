<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offence extends Model
{
    use HasFactory;
    protected $table = 'tbl_offences_lookup';
    protected $primaryKey = 'offence_id';
    public $timestamps = true;

    protected $fillable = [
        'offence_type',
    ];
}
