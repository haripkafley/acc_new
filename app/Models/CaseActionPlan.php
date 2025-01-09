<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseActionPlan extends Model
{
    protected $table = 'tbl_case_action_plans';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'case_no_id',
        'activity_category',
        'cycle',
        'actionplanstartdate',
        'actionplanenddate',
        'weekname',
        'remarks',
        'rating',
        'status',
    ];
}
