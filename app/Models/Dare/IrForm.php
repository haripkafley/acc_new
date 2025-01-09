<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IrForm extends Model
{
    use HasFactory;
    protected $table = "ir_form";

    public function area_name()
    {
        return $this->hasOne('App\Models\Area','id','area');
    }

    public function agency_name()
    {
        return $this->hasOne('App\Models\Complaint\agencyModel','agencyID','agency');
    }

    public function offence_name()
    {
        return $this->hasOne('App\Models\Offence','offence_id','corruption');
    }

    public function user_name()
    {
        return $this->hasOne('App\Models\User','id','report_by');
    }

    public function source_name()
    {
        return $this->hasOne('App\Models\Dare\Source','id','source');
    }

    public function ip_details()
    {
        return $this->hasOne('App\Models\Dare\IntelProject','ir_id','id');
    }


    public function report_details()
    {
        return $this->hasOne('App\Models\Dare\IpReport','ip_id','id');
    }

    public function dzongkhagrelation()
    {
        return $this->hasOne('App\Models\Dzongkhag', 'dzoID', 'dzongkhag_id');
    }


    public function gewogrelation()
    {
        return $this->hasOne('App\Models\Gewog', 'gewogID', 'gewog_id');
    }

    public function villagerelation()
    {
        return $this->hasOne('App\Models\Village', 'villageID', 'village');
    }

    public function ir_report()
    {
        return $this->hasOne('App\Models\Dare\IpFinalReport','ir_id','id');
    }



}
