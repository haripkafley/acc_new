<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseEvidence extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_evidences';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'evidence_subcategory',
        'evidence_category',
        'collected_on',
        'collected_by',
        'evidence_description',
        'evidence_no',
        'collected_from',
        'evidence_file_name',
        'evidence_file_extension',
        'evidence_name',
        'id'
    ];
}
