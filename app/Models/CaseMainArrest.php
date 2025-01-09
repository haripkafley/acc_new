<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseMainArrest extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_mainarrests';
    public $timestamps = true;
    protected $primaryKey = 'arrest_id';
    protected $fillable = [
        'case_no_id',
        'typeofArrest',
        'suspect',
        'applicationdate',
        'arrest_requested_by',
        'commissionStatus',
        'commissionReview',
        'arrested_from',
        'arrested_by',
        'arrested_on',
        'arrested_remarks',
    ];
}
