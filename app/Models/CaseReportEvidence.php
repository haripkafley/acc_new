<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseReportEvidence extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tbl_case_report_evidences';
    protected $fillable = [
        'id',
        'report_id',
        'evidence_id',
        'case_no_id' 
    ];
}
