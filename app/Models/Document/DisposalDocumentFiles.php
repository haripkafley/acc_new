<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposalDocumentFiles extends Model
{
    use HasFactory;
    protected $table = "document_disposal_files";

    public function file_single()
    {
        return $this->hasOne('App\Models\Document\ReceiptModel','id','receipt_id');
    }
}
