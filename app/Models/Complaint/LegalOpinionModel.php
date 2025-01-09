<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalOpinionModel extends Model
{
    use HasFactory;
    protected $table = "legal_opinion_model";

    public function eve_offence_details()
    {
        return $this->hasOne('App\Models\Complaint\CompalintEveOffence','id','offence_allegation');
    }
}
