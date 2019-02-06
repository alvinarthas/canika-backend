<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\KeteranganNotifikasi;
use App\Transaksi;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $fillable = ['keterangan','trx_id','customer_id','vendor_id','jenis','read'];

    public static function addNotifikasi($jenis,$trx,$ketnotif){
        $getketerangan = KeteranganNotifikasi::where('id',$ketnotif)->first();
        $info = Transaksi::getInfo($trx);
        $keterangan = "";
        //  Atur Notifikasi
            if($ketnotif == 1){
                // customer yg membatalkan
                if($jenis == 1){
                    $keterangan = $info->customer." ".$getketerangan->keterangan1." ".$info->barang." ".$getketerangan->keterangan2." ".$info->cancel_reason;
                // vendor yg membatalkan
                }elseif ($jenis == 2) {
                    $keterangan = $info->vendor." ".$getketerangan->keterangan1." ".$info->barang." ".$getketerangan->keterangan2." ".$info->cancel_reason;
                }
            }elseif ($ketnotif == 2 || $ketnotif == 3 || $ketnotif == 4 || $ketnotif == 5 || $ketnotif == 7) {
                $keterangan = $info->vendor." ".$getketerangan->keterangan1;
            }elseif ($ketnotif == 6) {
                $keterangan = $getketerangan->keterangan1." #CAN".$trx." ".$getketerangan->keterangan2;
            }elseif ($ketnotif == 8) {
                $keterangan = $info->vendor." ".$getketerangan->keterangan1." ".$info->date;
            }elseif ($ketnotif == 9|| $ketnotif == 10) {
                $keterangan = $getketerangan->keterangan1." ".$info->vendor;
            }elseif ($ketnotif == 11 || $ketnotif == 12 || $ketnotif == 13 || $ketnotif == 14) {
                $keterangan = $getketerangan->keterangan1;
            }elseif ($ketnotif == 15 || $ketnotif == 16 || $ketnotif == 19 || $ketnotif == 20 || $ketnotif == 25|| $ketnotif == 26) {
                $keterangan = $getketerangan->keterangan1." #CAN".$trx;
            }elseif ($ketnotif == 17 || $ketnotif == 18) {
                $keterangan = $info->customer." ".$getketerangan->keterangan1." #CAN".$trx." ".$getketerangan->keterangan2;
            }elseif ($ketnotif == 21 || $ketnotif == 22 || $ketnotif == 23 || $ketnotif == 24) {
                $keterangan = $getketerangan->keterangan1." #CAN".$trx." ".$getketerangan->keterangan2;
            }
        // Save
            $notifikasi = new Notifikasi(array(
                'keterangan' => $keterangan,
                'trx_id' => $trx,
                'customer_id' => $info->customer_id,
                'vendor_id' => $info->vendor_id,
                'read' => 0,
                'jenis' => $jenis,
            ));

            $notifikasi->save();
    }

    public static function getNotif($jenis,$user){
        if($jenis == 1){
            $notif = Notifikasi::join('tbl_customer','tbl_customer.id','=','notifikasi.customer_id')->where('jenis',$jenis)->where('customer_id',$user)->select('notifikasi.*','tbl_customer.avatar','tbl_customer.username')->paginate(5);
        }elseif($jenis == 2){
            $notif = Notifikasi::join('tbl_vendor','tbl_vendor.id','=','notifikasi.vendor_id')->where('jenis',$jenis)->where('vendor_id',$user)->select('notifikasi.*','tbl_vendor.avatar','tbl_vendor.username')->paginate(5);
        }
        return $notif;
    }
}
