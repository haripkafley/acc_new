<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'tbl_roles_lookup';
    public $timestamps = true;

    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role_name',
        'created_at',
        'updated_at',
    ];
}
