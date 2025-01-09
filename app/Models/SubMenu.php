<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;
    protected $table = 'tbl_mst_sub_menu';
    public function menu_name()
    {
        return $this->hasOne('App\Models\Menu','id','menu_id');
    }
}
