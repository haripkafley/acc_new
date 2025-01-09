<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storages extends Model
{
    use HasFactory;

    protected $table = "storage";

    public function file_details()
    {
        return $this->hasOne('App\Models\Document\ReceiptModel','id','file_id');
    }
}
