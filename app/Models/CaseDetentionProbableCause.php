<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseDetentionProbableCause extends Model
{
    use HasFactory;
    protected $table = 'tbl_case_detention_probable_causes';
    protected $primaryKey = 'id';
    protected $fillable = ['detention_id', 'name'];

    public function detention()
    {
        return $this->belongsTo(CaseDetention::class, 'detention_id', 'detention_id');
    }
}
