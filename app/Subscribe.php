<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'tbl_subscribe';
    protected $fillable = ['email'];
}
