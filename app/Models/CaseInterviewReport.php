<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseInterviewReport extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_interview_report';
    public $timestamps = true;
    protected $fillable = [
        'interviewplan_id',
        'interview_type',
        'interview_date',
        'start_time',
        'end_time',
        'interview_summary',
        'observation_summary',
        'interview_recorded',
        'interview_recording_url',
        'written_statement',
        'statement_writtenby',
        'statement_readby',
        'statement',
        'actual_location',
    ];
}
