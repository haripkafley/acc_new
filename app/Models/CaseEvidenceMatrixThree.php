<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseEvidenceMatrixThree extends Model
{
    protected $table = 'tbl_case_evidence_matrix_three';

    protected $fillable = [
        'table_two_id',
        'evidence_id',
        'textdetails',
    ];
}
