<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\KeteranganNotifikasi;
use App\Transaksi;
use App\Customer;

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

        Notifikasi::SendFcm($info->customer_id,$keterangan);
    }

    public static function getNotif($jenis,$user){
        if($jenis == 1){
            $notif = Notifikasi::join('tbl_customer','tbl_customer.id','=','notifikasi.customer_id')->where('jenis',$jenis)->where('customer_id',$user)->select('notifikasi.*','tbl_customer.avatar','tbl_customer.username')->paginate(5);
        }elseif($jenis == 2){
            $notif = Notifikasi::join('tbl_vendor','tbl_vendor.id','=','notifikasi.vendor_id')->where('jenis',$jenis)->where('vendor_id',$user)->select('notifikasi.*','tbl_vendor.avatar','tbl_vendor.username')->paginate(5);
        }
        return $notif;
    }

    public static function SendFcm($customer,$message){
        $device_id = Customer::where('id',$customer)->first()->deviceToken;
        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';

        /*api_key available in:
        Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/    
        $api_key = 'AAAAckWA5-I:APA91bHzQsWdSsWJDB9l705yzGe7WAD1of-kiU-Yfu2vsSgj1K7IiXHKi3O-eVZ00g3U8CqSXRp3enkXRrjQMNYsosMxqlAiAh4CbgIJzwXsS2-1jPFEVHef8b9giENqndvoYnj5UBgp';
                    
        $fields = array (
            'registration_ids' => array (
                    $device_id
            ),
            'data' => array (
                    "title" => "Canika Messaging",
                    "message" => $message
            )
        );

        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );
                    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}
