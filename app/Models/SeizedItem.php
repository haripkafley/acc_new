<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeizedItem extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_seized_items';
    public $timestamps = true;
    protected $fillable = [
        'seizure_id',
        'case_no_id',
        'item_type',
        'item_name',
        'manufacturer',
        'model',
        'serial_no',
        'condition',
        'email_address',
        'password',
        'oldpassword',
        'inbox',
        'spam',
        'draft',
        'sent',
        'platform',
        'passportno',
        'passportname',
        'passportissuedate',
        'passportexpirydate',
        'currencyamt',
        'status',
        'forensic_status',
    ];
}
