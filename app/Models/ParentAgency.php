<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentAgency extends Model
{
    use HasFactory;
    protected $table = 'tbl_parentagencies_lookup';
    public $timestamps = true;

    protected $fillable = [
        'parent_agency','parent_agency_id'
    ];
}
