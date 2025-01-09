<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseEvidenceMatrixTwo extends Model
{
    protected $table = 'tbl_case_evidence_matrix_two';

    protected $fillable = [
        'table_one_id',
        'element_id',
        'substantiate',
    ];
}
