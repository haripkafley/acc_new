<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseInterviewer extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_interviewers';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'interviewers',
        'interviewplan_id',
    ];
}
