<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeizureWitness extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tbl_case_seizure_witnesses';
    protected $fillable = [
        'seizure_id',
        'witness_name',
        'witness_cid',
    ];
}
