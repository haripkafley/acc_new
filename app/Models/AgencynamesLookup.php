<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencynamesLookup extends Model
{
    use HasFactory;
    protected $table = 'tbl_agencynames_lookup';
    protected $primaryKey = 'agency_name_id';
    
    public $timestamps = true;
    
    protected $fillable = [
        'agency_name',
    ];
}
