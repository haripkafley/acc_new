<?php

namespace App\Models\Ti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiReport extends Model
{
    use HasFactory;
    protected $table = "ti_report";

    public function officer_details()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }
}
