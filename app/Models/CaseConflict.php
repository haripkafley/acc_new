<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseConflict extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_conflicts';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'name',
        'email',
        'declared_by',
        'nature_of_conflict',
        'conflict_status',
        
    ];
}
