<?php

namespace App\Models\Dare;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idiary extends Model
{
    use HasFactory;
    protected $table = "ir_idiary";

    public function ir_details()
    {
        return $this->hasOne('App\Models\Dare\IrForm','id','ip_id');
    }

    public function ti_details()
    {
        return $this->hasOne('App\Models\Ti\TackticalInteligence','id','ip_id');
    }
}
