<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rekening;

class Rekening extends Model
{
    protected $table = 'tbl_rekening';
    protected $fillable = ['bank_id','nama_pemilik','norek'];

    public function bank(){
        return $this->belongsTo('App\Bank');
    }
}
