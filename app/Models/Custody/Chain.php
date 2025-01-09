<?php

namespace App\Models\Custody;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chain extends Model
{
    use HasFactory;
    protected $table = "custody_chain";

    public function item_details()
    {
        return $this->hasOne('App\Models\CustodyStorageProperty','id','item_id');
    }
}
