<?php

namespace App\Models\Ti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiSirReport extends Model
{
    use HasFactory;
    protected $table = "ti_sir_report";

    public function officer_details()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }

    public function source_name()
    {
        return $this->hasOne('App\Models\Dare\Source','id','source');
    }

    public function status_details()
    {
        return $this->hasOne('App\Models\Dare\IpStatus','id','status');
    }


}
