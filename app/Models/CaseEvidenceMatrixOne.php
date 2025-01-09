<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseEvidenceMatrixOne extends Model
{
    protected $table = 'tbl_case_evidence_matrix_one';

    // Specify the primary key if it's different from the default 'id'
    protected $primaryKey = 'id';

    // Define fillable columns to allow mass assignment
    protected $fillable = [
        'accused_id',
        'offence_id',
        'description',
        'count',
        'saved',
        'case_no_id'
    ];

    // Disable timestamps if they are not needed
    public $timestamps = true;
}
