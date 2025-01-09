<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseHypothesis extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_hypothesis';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'hypotheses',
        'evaluation_status',
        'evaluated_on',
    ];
}
