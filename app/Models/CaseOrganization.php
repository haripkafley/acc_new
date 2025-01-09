<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseOrganization extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_organizations';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
        'business_license_no',
        'business_location',
        'business_owner',
        'organization_name',
        'business_license_issue_date',
        'business_license_expiry_date',
        'business_activity',
        'contact_person',
        'phone_no',
        'email',
        'parent_agency',
        'organization_type',
    ];
}
