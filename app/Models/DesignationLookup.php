<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationLookup extends Model
{
    use HasFactory;
    protected $table = 'tbl_designations_lookup';
    protected $primaryKey = 'designation_id';
    public $timestamps = true;

    protected $fillable = [
        'designation_name',
    ];
}
