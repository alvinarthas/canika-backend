<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'tbl_bank';
    protected $fillable = ['nama','image'];

    public static function showAll(){
        return Bank::join('tbl_rekening as r','r.bank_id','=','tbl_bank.id')
        ->get();
    }
}
