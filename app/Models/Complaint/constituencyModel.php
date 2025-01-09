<?php

namespace App\Models\Complaint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class constituencyModel extends Model
{
    use HasFactory;
    protected $table = 'pl_tblconstituency';
    protected $primaryKey = 'constituencyID';

    public function getDzongkhagDetails(){
        return $this->hasOne('App\Models\Dzongkhag', 'dzoID', 'dzoID');
    }
}
