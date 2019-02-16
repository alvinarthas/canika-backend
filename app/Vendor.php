<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vendor extends Model
{
    protected $table = 'tbl_vendor';
    protected $fillable = ['username','password','email','hp','nama','deskripsi','avatar','status','verifyToken','email_konf','sms_konf','kode_pos','contact_person','jabatan','email_perusahaan','website','alamat','bank','no_rek','pemilik_rek','cabang_bank','notif_id','prov','kota'];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function barang(){
        return $this->hasMany('App\Barang');
    }
    public static function verifyAccount($email,$token){
        return Vendor::where(['email'=>$email,'verifyToken'=>$token])->update(['status'=>'1','email_konf'=>1,'verifyToken'=>NULL]);
    }

    public static function getCategory($id){
        return Barang::join('tbl_vendor','tbl_vendor.id','=','tbl_barang.vendor_id')->where('tbl_barang.kat_id',$id)->select('tbl_vendor.id','tbl_vendor.nama','tbl_vendor.avatar')->distinct()->get();
    }

    public static function getRating($id){
        $rating = Barang::join('tbl_rating','tbl_rating.barang_id','=','tbl_barang.id')->join('tbl_vendor as a','a.id','=','tbl_barang.vendor_id')->where('a.id',$id)->orderBy(DB::raw('(SUM(value) / COUNT(value))'),'desc')->select(DB::raw('(SUM(value) / COUNT(value)) as rata'))->get();
        return $rating;
    }

    public static function searchVendor($param){
        $barangall = Barang::join('tbl_vendor','tbl_vendor.id','=','tbl_barang.vendor_id')->where('tbl_barang.nama','like','%'.$param.'%')->orWhere('tbl_vendor.nama','like','%'.$param.'%')->select('tbl_vendor.id','tbl_vendor.nama','tbl_vendor.avatar')->groupBy('tbl_barang.vendor_id')->distinct()->get();
        return $barangall;
    }

}
