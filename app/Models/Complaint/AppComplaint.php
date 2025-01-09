<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppComplaint extends Model
{
    use HasFactory;
    protected $table = 'complaint';

    public function offence_name()
    {
        return $this->hasOne('App\Models\Complaint\Offence','id','offence_id');
    }

    public function area_name()
    {
        return $this->hasOne('App\Models\Complaint\Area','id','area_id');
    }
}
