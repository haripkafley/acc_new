<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseEvidenceFile extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_evidence_files';
    public $timestamps = true;
    protected $fillable = [
        'evidence_id',
        'evidence_path',
        'evidence_name',
        'case_no_id',
    ];
}
