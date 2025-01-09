<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseReport extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tbl_case_reports';
    protected $fillable = [
        'id',
        'case_no_id',
        'report_type_id',
        'report_name',
        'created_by',
        'summary'
    ];
}
