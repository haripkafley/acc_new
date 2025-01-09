<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseAsset extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_assets';
    public $timestamps = true;
    protected $fillable = [
        'asset_type',
        'case_no_id',
        'cidno',
        'plotno',
        'thramno',
        'area',
        'owner',
        'location_dzongkhag',
        'location_gewog',
        'location_village',
        'location_address',
        'building_no',
        'noofunits',
        'vehicletype',
        'vehicle_registrationno',
        'vehicle_registrationdate',
        'bank_name',
        'bank_accounttype',
        'bank_accountno',
        'freeze_date',
        'unfreeze_date',
        'status',
    ];
}
