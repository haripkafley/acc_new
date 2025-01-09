<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseReportEntity extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tbl_case_report_entities';
    protected $fillable = [
        'id',
        'report_id',
        'entity_id',
        'case_no_id'
    ];
}
