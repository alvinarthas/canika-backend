<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tbl_customer';
    protected $fillable = [
        'username', 'email', 'password','hp','first_name','last_name','tanggal_lahir','tempat_lahir','prov','kota','tanggal_nikah','avatar','status','verifyToken','gender','notif_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
 
    public static function verifyAccount($email,$token){
        return Customer::where(['email'=>$email,'verifyToken'=>$token])->update(['status'=>'1','verifyToken'=>NULL]);
    }
}
