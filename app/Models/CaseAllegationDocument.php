<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseAllegationDocument extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_allegation_documents';
    protected $fillable = ['case_no_id', 'doc_name', 'file_name'];
    public $timestamps = true;
}
