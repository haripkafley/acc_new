<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseOffenceTypesInvPlan extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tbl_case_offencetypesinvplans';
    protected $fillable = [
        'case_no_id',
        'offence_type',
        'others',
    ];
}
