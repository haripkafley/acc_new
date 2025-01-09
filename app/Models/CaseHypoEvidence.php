<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseHypoEvidence extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_hypo_evidences';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'evidences',
        'hypothesis_id',
    ];
}
