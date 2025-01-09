<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseInterviewPlan extends Model
{
    use HasFactory;
    public $timestamps = true;
     protected $table = 'tbl_case_interviewplans';
    protected $fillable = [
        'case_no_id',
        'accused',
        'interview_date',
        'location',
        'defences',
        'facts_established',
        'report_to',
        'report_date',
        'report_time',
        'report_venue',
        'status',
        'remarks',
    ];
}

