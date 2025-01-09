<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseEntity extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_entities';
    public $timestamps = true;
    protected $fillable = [
        'case_no_id',
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
        'entitytype',
        'involvement',
        'photo_name',
        'photo_extension',
        'id'
    ];
}
