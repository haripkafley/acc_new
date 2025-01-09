<?php

namespace App\Models\Ti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SirNewReport extends Model
{
    use HasFactory;
    protected $table = "ti_new_sir_report";

    public function source_name()
    {
        return $this->hasOne('App\Models\Dare\Source','id','source_code');
    }
}
