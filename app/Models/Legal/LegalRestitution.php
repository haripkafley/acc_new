<?php

namespace App\Models\Legal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalRestitution extends Model
{
    use HasFactory;
    protected $table = "legal_restitution";

    public function offence_name()
    {
        return $this->hasOne('App\Models\Offence','offence_id','offence');
    }
}
