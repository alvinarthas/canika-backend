<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'tbl_payment';
    protected $fillable = ['trx_id','method','status','bukti_bayar','bank','tgl_trf','nama_pengirim','bank_pengirim'];

    public function bank(){
        return $this->belongsTo('App\Bank','bank');
    }

    public function trx(){
        return $this->belongsTo('App\Transaksi');
    }
}
