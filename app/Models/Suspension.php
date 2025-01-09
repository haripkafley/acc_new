<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tbl_case_suspensions';
    protected $fillable = [
        'case_no_id',
        'suspension_type',
        'name',
        'employeeno',
        'dateofappointment',
        'positiontitle',
        'parentagency',
        'workingagency',
        'identification_no',
        'issue_date',
        'revoke_reason',
        'revoke_date',
        'suspension_status',
        'suspension_reason',
        'suspended_on',
        'business_license_no',
        'business_location',
        'business_owner',
        'business_name',
        'business_license_issue_date',
        'business_license_expiry_date',
        'business_activity',
    ];
}
