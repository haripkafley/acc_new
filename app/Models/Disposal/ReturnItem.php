<?php

namespace App\Models\Disposal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    use HasFactory;
    protected $table="disposal_return_items";

    public function item_details()
    {
        return $this->hasOne('App\Models\CustodyStorageProperty','id','item_id');
    }
}
