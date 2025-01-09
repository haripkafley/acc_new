<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseInvestigationPlan extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_investigation_plans';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'case_background',
        'allegations',
        'objectives',
        'scope',
        'status',
        'case_end_date',
        'case_start_date',
        'startdate_actionplan',
        'evaluation_status',
        'id'
    ];
}
