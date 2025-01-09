<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseIdiary extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_idiary';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'case_no_id',
        'date',
        'status',
        'assigned_to',
        'task_to_be_done',
        'remarks',
        'activity_category',
        'rating',
        'start_time',
        'end_time',
    ];
}
