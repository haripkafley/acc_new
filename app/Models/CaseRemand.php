<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseRemand extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'tbl_case_remands';
    protected $fillable = [
        'detention_id',
        'case_no_id',
        'remand_status',
        'remanded_until',
        'court',
        'remand_file_name',
        'released_on',
        'type_of_release',
        'bail_amount',
        'bail_document_name',
        'bail_bond_undertaking_name',
        'bond_receipt_name',
        'surety_name',
        'surety_cid',
        'relationship_surety',
        'surety_phone',
        'surety_undertaking_name',
    ];
}
