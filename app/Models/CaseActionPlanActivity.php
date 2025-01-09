<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseActionPlanActivity extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_actionplan_activities';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'case_no_id',
        'actionplanid',
        'task',
        'description',
        'priority',
        'assigned_to',
        'due_date',
        'assigned_on',
        'date_of_completion',
        'status',
    ];
}
