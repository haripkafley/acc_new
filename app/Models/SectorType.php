<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectorType extends Model
{
    use HasFactory;
    protected $table = 'tbl_sectortypes_lookup';
    public $timestamps = true;

    protected $fillable = [
        'sector_type',
    ];
}
