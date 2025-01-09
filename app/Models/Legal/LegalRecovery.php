<?php

namespace App\Models\Legal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalRecovery extends Model
{
    use HasFactory;
    protected $table = "legal_recovery";

    public function offence_name()
    {
        return $this->hasOne('App\Models\Offence','offence_id','offence');
    }
}
