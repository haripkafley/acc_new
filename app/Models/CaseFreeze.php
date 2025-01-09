<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseFreeze extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_freezes';
    public $timestamps = true;
    protected $fillable = [
        'asset_id',
        'freeze_date',
        'freeze_details',
        'frozen_by',
        'unfreeze_date',
        'unfreeze_details',
    ];
}
