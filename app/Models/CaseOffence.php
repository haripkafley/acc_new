<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseOffence extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_offences';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'offence_type',
    ];
}
