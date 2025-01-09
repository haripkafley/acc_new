<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseMainSeizure extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_mainseizures';
    protected $primaryKey = 'seizure_id';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'search_id',
        'seizure_type',
        'authorization_type',
        'seizure_date',
        'seizure_time',
        'seized_from_name',
        'seized_from_cid',
    ];
}

