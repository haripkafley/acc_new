<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpSirReport extends Model
{
    use HasFactory;
    protected $table = "ip_sir_report";

    public function source_name()
    {
        return $this->hasOne('App\Models\Dare\Source','id','source_code');
    }
}
