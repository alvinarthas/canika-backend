<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = 'block';
    protected $fillable = ['customer_id','vendor_id'];
}
