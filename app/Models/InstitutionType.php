<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionType extends Model
{
    use HasFactory;
     protected $table = 'tbl_institutiontypes_lookup';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'institution_type',
    ];
}
