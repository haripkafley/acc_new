<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplainEvaluationDecision extends Model
{
    use HasFactory;

    protected $table = 'ce_pltblcomplaintsevaluationdecisions';
    protected $primaryKey = 'compEvaDecisionID';
}
