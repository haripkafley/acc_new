<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComissionMember extends Model
{
    use HasFactory;
    protected $table = "ip_comission_member";
    
    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function commission_details()
    {
        return $this->hasOne('App\Models\Dare\IpComission','id','ir_id'); //here id means com id
    }
}
