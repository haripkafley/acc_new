<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseFactsToDetermine extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_factstodetermine';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'interviewplanid',
        'point_id',
        'interview_fact',
    ];
}
