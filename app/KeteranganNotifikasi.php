<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeteranganNotifikasi extends Model
{
    protected $table = 'keterangan_notifikasi';
    protected $fillable = ['keterangan1','keterangan2',];
}
