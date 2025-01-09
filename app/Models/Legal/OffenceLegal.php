<?php

namespace App\Models\Legal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffenceLegal extends Model
{
    use HasFactory;
    protected $table = "legal_offences";

    public function offence_name()
    {
        return $this->hasOne('App\Models\Offence','offence_id','offence');
    }
}
