<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $table = 'tbl_branch_lookup';
    protected $primaryKey = 'branch_id';
      public $timestamps = true;

    protected $fillable = [
        'branch_name',
        'branch_head',
    ];
}
