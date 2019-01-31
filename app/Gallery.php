<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'tbl_gallery';
    protected $fillable = ['barang_id','image'];
}
