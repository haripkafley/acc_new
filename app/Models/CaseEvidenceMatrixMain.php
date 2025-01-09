<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseEvidenceMatrixMain extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_evidence_matrix_main';
    public $timestamps = true;
    protected $fillable = [
        'accused_id',
        'offence_id',
        'maindescription',
        'case_no_id',
        'counting',
        'saved',
        'id'
    ];
}
