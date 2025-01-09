<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoleMapping extends Model
{
    use HasFactory;
    protected $table = 'tbl_user_role_mapping';
    public $timestamps = true;

    protected $fillable = [
        'assigned_by',
        'assigned_to',
        'role',
        'assigned_on',
        'case_no_id',
        'conflictstatus',
    ];
}
