<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSignature extends Model
{
    use HasFactory;
     protected $table = 'tbl_user_signatures';
     public $timestamps = true;

    protected $fillable = [
        'email',
        'name',
        'path',
    ];
}
