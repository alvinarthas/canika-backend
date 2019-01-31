<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeteranganPayment extends Model
{
    protected $table = 'keterangan_payment';
    protected $fillable = ['keterangan'];
}
