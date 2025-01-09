<?php

namespace App\Models\Custody;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashStorage extends Model
{
    use HasFactory;
    protected $table = "custody_cash_storage";
}
