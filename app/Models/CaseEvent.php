<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseEvent extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_events';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'category',
        'name',
        'date',
        'time',
        'description',
        'conducted_by',
    ];
}
