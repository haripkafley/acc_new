<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseInterviewDocument extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_interview_documents';
    public $timestamps = true;
    protected $fillable = [
        'interviewplan_id',
        'documents',
        'quantity',
        'remarks',
    ];
}
