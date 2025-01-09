<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElementLookup extends Model
{
    use HasFactory;
    protected $table = 'tbl_elements_lookup';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'element_name',
        'offence_id',
        'required',
        'id'
    ];
}
