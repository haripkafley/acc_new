<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renewal extends Model
{
    use HasFactory;

    protected $table = "document_renewal";

    public function file_details()
    {
        return $this->hasOne('App\Models\Document\ReceiptModel','id','file_id');
    }
}
