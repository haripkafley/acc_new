<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mainseizure extends Model
{
    public $timestamps=false;
    protected $fillable = [
        'seizure_id', 
        'case_no_id',
        'currency_type',
        'denomination',
        'frequency',
        'amount',
        'manufacturer',
        'model',
        'serialNo',
        'condition',
        'remarks',
        'item',
        'email',
        'password',
        'inbox',
        'sent',
        'draft',
        'spam',
        'oldpassword',
        'phoneNo',
        'passport_no',
        'name',
        'issue_date',
        'expiry_date',
        'platform',
        'account_name',
        'social_password',
        'social_old_password',
        'seizure_type',
        'assignstatus'
    ];
}
