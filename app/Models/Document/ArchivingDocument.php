<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivingDocument extends Model
{
    use HasFactory;

    protected $table = "archiving_documentation";

    public function file_details()
    {
        return $this->hasOne('App\Models\Document\ReceiptModel','id','file_id');
    }
}
