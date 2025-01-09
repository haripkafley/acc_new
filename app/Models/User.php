<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
     public $timestamps = true;

    protected $fillable = [
        'status',
        'accept_status',
        'name',
        'email',
        'username',
        'password',
        'profile_image',
        'role',
        'agency_name',
        'employee_id',
        'department',
        'branch',
        'position',
        'mobile',
        'expected_role',
        'email_verified_at',
        'remember_token',
        'security_question',
        'security_answer',
    ];

    public function department_name()
    {
        return $this->hasOne('App\Models\Department','id','department');
    }

    public function region_name()
    {
        return $this->hasOne('App\Models\Department','id','department');
    }
}
