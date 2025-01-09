<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpComission extends Model
{
    use HasFactory;
    protected $table = "ip_comission_decision";


    public function status_details()
    {
        return $this->hasOne('App\Models\Comstatus','id','decision');
    }
}
