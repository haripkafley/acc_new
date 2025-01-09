<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoryFine extends Model
{
    use HasFactory;
    protected $table = 'monitory_fine';

    public function eve_offence_details()
    {
        return $this->hasOne('App\Models\Complaint\CompalintEveOffence','id','offence_allegation');
    }
}
