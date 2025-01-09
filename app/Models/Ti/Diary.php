<?php

namespace App\Models\Ti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;
    protected $table = "ti_diary";

    public function officer_details()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }

    
    public function ir_details()
    {
        return $this->hasOne('App\Models\Dare\IrForm','id','ti_id');
    }

    public function ti_details()
    {
        return $this->hasOne('App\Models\Ti\TackticalInteligence','id','ti_id');
    }

    


}
