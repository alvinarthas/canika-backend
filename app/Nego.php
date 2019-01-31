<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nego extends Model
{
    protected $table = 'tbl_nego';
    protected $fillable = ['customer_id','barang_id','harga','qty','status','tgl_booking'];
}
