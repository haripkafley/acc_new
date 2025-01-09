<?php

namespace App\Models\Custody;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    use HasFactory;
    protected $table = "custody_maintenance_log";

    public function item_details()
    {
        return $this->hasOne('App\Models\CustodyStorageProperty','id','item_id');
    }
}
