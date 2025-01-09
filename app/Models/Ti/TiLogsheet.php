<?php

namespace App\Models\Ti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiLogsheet extends Model
{
    use HasFactory;
    protected $table = "ti_log_sheet";

    public function officer_details()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }

    public function ti_details()
    {
        return $this->hasOne('App\Models\Ti\TackticalInteligence','id','ti_id');
    }
}
