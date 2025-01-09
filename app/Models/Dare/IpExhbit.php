<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpExhbit extends Model
{
    use HasFactory;
    protected $table = "ip_exhibits";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','collected_by');
    }

    public function exhibit_report()
    {
        return $this->hasOne('App\Models\Dare\ExhibitReport','exhi_id','id');
    }
}
