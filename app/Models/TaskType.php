<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    use HasFactory;
    protected $table = 'tbl_task_types_lookup';
    
    public $timestamps = true;

    protected $fillable = [
        'task_name',
    ];
}
