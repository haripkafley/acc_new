<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseDetention extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_detentions';
    protected $primaryKey = 'detention_id';
    protected $fillable = [
        'case_no_id',
        'suspect',
        'gender',
        'detained_from',
        'detained_on',
        'detained_by',
        'detention_facility',
        'status',
    ];
}
