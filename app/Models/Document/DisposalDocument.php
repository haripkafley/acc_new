<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisposalDocument extends Model
{
    use HasFactory;
    protected $table = "document_disposal";

    public function files_details()
    {
        return $this->hasMany('App\Models\Document\DisposalDocumentFiles','disposal_id','id');
    }
}
