<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    protected $table = 'tbl_admin';
    protected $fillable = ['username','nama','avatar','status'];
    protected $hidden = [
        'password',
    ];

}
