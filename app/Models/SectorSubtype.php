<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectorSubtype extends Model
{
    use HasFactory;
    protected $table = 'tbl_sectorsubtypes_lookup';
    public $timestamps = true;

    protected $fillable = [
        'sector_name',
    ];
}
