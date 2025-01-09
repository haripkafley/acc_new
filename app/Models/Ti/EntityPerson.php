<?php

namespace App\Models\Ti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntityPerson extends Model
{
    use HasFactory;
    protected $table = "ti_entities";

    protected $fillable = [
        'ti_id',
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
