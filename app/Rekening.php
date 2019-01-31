<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table = 'tbl_rekening';
    protected $fillable = ['bank_id','nama_pemilik','norek'];
}
