<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'tbl_komentar';
    protected $fillable = ['customer_id','barang_id','konten'];
}
