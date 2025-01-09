<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    protected $table = 'tbl_user_signatures';
    protected $fillable = [
        'id','name', 'path','email'
    ];
}
