<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'tbl_admins';
    protected $fillable = ['username','nama','avatar','status'];
    protected $hidden = [
        'password',
    ];

}
