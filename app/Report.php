<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Customer;
use App\Vendor;

class Report extends Model
{
    protected $table = 'tbl_report';
    protected $fillable = ['user_id','jenis','keterangan'];

    public static function getList($jenis){
        if($jenis == 0){ // user
            $user = Report::join('tbl_customer','tbl_customer.id','=','tbl_report.user_id')->select(DB::raw('tbl_customer.*, tbl_report.keterangan'))->get();
        }else{ // vendor
            $user = Report::join('tbl_vendor','tbl_vendor.id','=','tbl_report.user_id')->select(DB::raw('tbl_vendor.*, tbl_report.keterangan'))->get();
        }
        return $user;
    }

    public static function getDetail($jenis,$user){
        if($jenis == 0){ // user
            $user = Report::join('tbl_customer','tbl_customer.id','=','tbl_report.user_id')->select(DB::raw('tbl_customer.*, tbl_report.keterangan'))->where('user_id',$user)->first();
        }else{ // vendor
            $user = Report::join('tbl_vendor','tbl_vendor.id','=','tbl_report.user_id')->select(DB::raw('tbl_vendor.*, tbl_report.keterangan'))->where('user_id',$user)->first();
        }
        return $user;
    }
}
