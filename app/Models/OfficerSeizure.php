<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficerSeizure extends Model
{
    use HasFactory;
    protected $table = 'tbl_officer_seizure';
    public $timestamps = true;

    protected $fillable = [
        'seizure_id',
        'officer_email',
    ];
}
