<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpEntities extends Model
{
    use HasFactory;
    protected $table = "ip_entities";

    protected $fillable = [
        'ip_id',
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
