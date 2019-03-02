<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trxhistory extends Model
{
    protected $table = 'tbl_trxhistory';
    protected $fillable = ['trx_id','catatan','status','max_date'];

    public function keterangan(){
        return $this->belongsTo('App\KeteranganPayment','status');
    }
}
