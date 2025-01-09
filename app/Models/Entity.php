<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;
    protected $table = 'tbl_entities';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'identification_no',
        'name',
        'dateofbirth',
        'gender',
        'type',
        'dzongkhag',
        'village',
        'gewog',
        'address',
        'contactno',
        'email',
        'permanentaddress',
        'photo_name',
        'photo_extension',
        
    ];
}
