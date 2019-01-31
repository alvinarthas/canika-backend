<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'tbl_role';
    protected $fillable = ['role','deskripsi'];
}
