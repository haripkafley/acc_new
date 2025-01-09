<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $table = 'tbl_areas_lookup';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'area_name',
    ];
}
