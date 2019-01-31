<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'tbl_payment';
    protected $fillable = ['trx_id','method','status','bukti_bayar','bank','tgl_trf','nama_pengirim','bank_pengirim'];
}
