<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredCase extends Model
{
    use HasFactory;
    protected $table = 'tbl_registered_cases';
    public $timestamps = true;

    protected $fillable = [
        'case_no',
        'case_id',
        'case_title',
        'source_type',
        'sector',
        'sector_type',
        'area',
        'institution_type',
        'allegation_doc_name',
        'allegation_doc_extension',
        'allegation_details',
        'instructions',
        'priority',
        'investigation_type',
        'branch',
        'agency_name',
        'creation_date',
        'expected_end_date',
        'reassignment_reason',
        'status',
        'sub_status',
        'assigned_status',
        'assignment_order_date',
        'case_summary',
        'reassignmentstatus',
        'id'
        
    ];
}
