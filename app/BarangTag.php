<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangTag extends Model
{
    protected $table = 'brg_tag';
    protected $fillable = ['barang_id','tag_id'];
}
