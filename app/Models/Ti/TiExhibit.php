<?php

namespace App\Models\Ti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiExhibit extends Model
{
    use HasFactory;
    protected $table = "ti_exhibits";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','collected_by');
    }
}
