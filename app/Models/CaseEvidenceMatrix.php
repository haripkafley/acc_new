<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseEvidenceMatrix extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_evidence_matrix';
    public $timestamps = true;
    protected $fillable = [
        'offence_id',
        'element_id',
        'id_main_matrix',
        'evidence_id',
        'required',
        'textdetails',
        'substantiate',
        'id'
        
    ];
}
