<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'tbl_admin';
    protected $fillable = ['username','nama','avatar'];
    protected $hidden = [
        'password',
    ];

}
