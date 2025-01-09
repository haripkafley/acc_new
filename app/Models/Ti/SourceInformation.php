<?php

namespace App\Models\Ti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceInformation extends Model
{
    use HasFactory;
    protected $table = "ti_source_information";

    public function officer_details()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }

    public function agency_name()
    {
        return $this->hasOne('App\Models\Complaint\agencyModel','agencyID','agency');
    }

    public function status_details()
    {
        return $this->hasOne('App\Models\Dare\IpStatus','id','status');
    }

    public function tacktical_details()
    {
        return $this->hasOne('App\Models\Ti\TackticalInteligence','id','ti_id');
    }

    public function source_name()
    {
        return $this->hasOne('App\Models\Dare\Source','id','source_code');
    }
}
