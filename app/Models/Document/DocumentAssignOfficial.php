<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentAssignOfficial extends Model
{
    use HasFactory;
    protected $table = "document_assign_official";

    public function user_details()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }


}
