<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Vendor;
use App\Bank;
use App\Rekening;

class Transaksi extends Model
{
    protected $table = 'tbl_trx';
    protected $fillable = ['customer_id','barang_id','harga','qty','status','catatan','dp_status','dp_persen','cancel_reason,cancel_by'];

    public static function awal($barang,$customer){
        return Vendor::join('tbl_barang','tbl_vendor.id','=','tbl_barang.vendor_id')
        ->join('tbl_nego','tbl_barang.id','=','tbl_nego.barang_id')
        ->join('tbl_gallery','tbl_barang.id','=','tbl_gallery.barang_id')
        ->where('tbl_nego.customer_id',$customer)->where('tbl_nego.barang_id',$barang)
        ->select('tbl_vendor.nama','tbl_barang.nama AS barang','tbl_gallery.image','tbl_nego.harga')
        ->limit(1)->get();
    }

    public static function trxCustomer($customer){
        $transaksi = Transaksi::where('customer_id',$customer)->where('status',0)->get();
        $data = collect();
        foreach($transaksi as $trx){
            $newtrx =  Transaksi::join('tbl_barang as b','b.id','=','tbl_trx.barang_id')
            ->join('tbl_vendor as v','v.id','=','b.vendor_id')
            ->join('tbl_gallery as g','b.id','=','g.barang_id')
            ->join('tbl_trxhistory as t','t.trx_id','=','tbl_trx.id')
            ->join('keterangan_payment as k','t.status','=','k.id')
            ->select(DB::raw('tbl_trx.id as trx_id,tbl_trx.harga,tbl_trx.dp_persen,v.nama as vendor,v.avatar,b.nama as barang,g.image,k.keterangan,tbl_trx.dp_status,tbl_trx.created_at as tgl_trx'))
            ->where('tbl_trx.id',$trx->id)
            ->orderBy('g.id','ASC')
            ->orderBy('t.created_at','DESC')
            ->limit(1)
            ->first();
            $data->push($newtrx);
        }
        return $data;
    }

    public static function trxCustomerdet($trx){
        $newtrx =  Transaksi::join('tbl_barang as b','b.id','=','tbl_trx.barang_id')
        ->join('tbl_vendor as v','v.id','=','b.vendor_id')
        ->join('tbl_gallery as g','b.id','=','g.barang_id')
        ->join('tbl_trxhistory as t','t.trx_id','=','tbl_trx.id')
        ->join('tbl_customer as c','c.id','=','tbl_trx.customer_id')
        ->join('keterangan_payment as k','t.status','=','k.id')
        ->select(DB::raw('tbl_trx.id as trx_id,tbl_trx.harga,tbl_trx.dp_persen,v.nama as vendor,v.avatar,b.nama as barang,g.image,k.keterangan,tbl_trx.dp_status,tbl_trx.created_at as tgl_trx,c.username as customer, c.avatar as customer_avatar,c.tanggal_nikah,b.id as barang_id'))
        ->where('tbl_trx.id',$trx)
        ->orderBy('g.id','ASC')
        ->orderBy('t.created_at','DESC')
        ->limit(1)
        ->first();

        return $newtrx;
    }

    public static function trxHistory($customer){
        $transaksi = Transaksi::where('customer_id',$customer)->whereIn('status',array(1,99))->get();
        $data = collect();
        foreach($transaksi as $trx){
            $newtrx =  Transaksi::join('tbl_barang as b','b.id','=','tbl_trx.barang_id')
            ->join('tbl_vendor as v','v.id','=','b.vendor_id')
            ->join('tbl_gallery as g','b.id','=','g.barang_id')
            ->join('tbl_trxhistory as t','t.trx_id','=','tbl_trx.id')
            ->join('keterangan_payment as k','t.status','=','k.id')
            ->select(DB::raw('tbl_trx.status,tbl_trx.id as trx_id,tbl_trx.harga,tbl_trx.dp_persen,v.nama as vendor,v.avatar,b.nama as barang,g.image,k.keterangan'))
            ->where('tbl_trx.id',$trx->id)
            ->orderBy('g.id','ASC')
            ->orderBy('t.created_at','DESC')
            ->limit(1)
            ->get();
            $data->push($newtrx[0]);
        }
        return $data;
    }

    public static function paymentAwal($trx){
        $payment = collect();

        $transaksi =  Transaksi::join('tbl_trxhistory as t','t.trx_id','=','tbl_trx.id')
        ->join('keterangan_payment as k','t.status','=','k.id')
        ->select(DB::raw('tbl_trx.id as trx_id,tbl_trx.harga,tbl_trx.dp_status,tbl_trx.dp_persen,k.keterangan'))
        ->where('tbl_trx.id',$trx)
        ->first();
        $payment->put('transaksi',$transaksi);

        $bank = Bank::join('tbl_rekening as r','r.bank_id','=','tbl_bank.id')
        ->get();
        $payment->put('bank',$bank);

        return $payment;
    }

    public static function awalan($trx){
        return Transaksi::join('tbl_trxhistory as t','t.trx_id','=','tbl_trx.id')
        ->join('keterangan_payment as k','t.status','=','k.id')
        ->select(DB::raw('tbl_trx.id as trx_id,tbl_trx.harga,tbl_trx.dp_status,tbl_trx.dp_persen,k.keterangan,t.max_date'))
        ->where('tbl_trx.id',$trx)
        ->first();
    }

    public static function konfirmasiPayment($trx){
        return Transaksi::join('tbl_trxhistory as t','t.trx_id','=','tbl_trx.id')
        ->join('keterangan_payment as k','t.status','=','k.id')
        ->join('tbl_payment as p','p.trx_id','=','tbl_trx.id')
        ->join('tbl_bank as b','b.id','=','p.bank')
        ->join('tbl_rekening as r','r.bank_id','=','b.id')
        ->select(DB::raw('tbl_trx.id as trx_id,tbl_trx.harga,tbl_trx.dp_status,tbl_trx.dp_persen,k.keterangan,t.max_date,b.nama as bank,b.image as bank_image,r.nama_pemilik,r.norek,p.id as payment_id'))
        ->where('tbl_trx.id',$trx)
        ->first();
    }

    public static function trxVendor($vendor,$status){
        $transaksi = Transaksi::join('tbl_barang as b','tbl_trx.barang_id','=','b.id')
            ->join('tbl_vendor as v','v.id','=','b.vendor_id')
            ->where('tbl_trx.status',$status)
            ->where('v.id',$vendor)
            ->select(DB::raw('tbl_trx.id'))
            ->get();

        $data = collect();
        foreach($transaksi as $trx){
            $newtrx =  Transaksi::join('tbl_barang as b','b.id','=','tbl_trx.barang_id')
            ->join('tbl_customer as c','c.id','=','tbl_trx.customer_id')
            ->join('tbl_gallery as g','b.id','=','g.barang_id')
            ->join('tbl_trxhistory as t','t.trx_id','=','tbl_trx.id')
            ->join('keterangan_payment as k','t.status','=','k.id')
            ->select(DB::raw('tbl_trx.id as trx_id,tbl_trx.harga,tbl_trx.dp_persen,c.username as customer,c.avatar,b.nama as barang,g.image,k.keterangan,tbl_trx.dp_status,c.tanggal_nikah'))
            ->where('tbl_trx.id',$trx->id)
            ->orderBy('g.id','ASC')
            ->orderBy('t.created_at','DESC')
            ->limit(1)
            ->first();
            
            $data->push($newtrx);
        }
        return $data;
    }

    public static function getInfo($trx_id){
        return Transaksi::join('tbl_customer as c','c.id','=','tbl_trx.customer_id')
        ->join('tbl_barang as b','b.id','=','tbl_trx.barang_id')
        ->join('tbl_vendor as v','b.vendor_id','=','v.id')
        ->select(DB::raw('c.username as customer,c.id as customer_id,b.nama as barang,b.id as barang_id, v.nama as vendor, v.id as vendor_id,tbl_trx.created_at as date,tbl_trx.cancel_reason'))
        ->where('tbl_trx.id',$trx_id)
        ->first();
    }

    // ADMIN
    public static function listTrx(){
        return Transaksi::join('tbl_customer as c','c.id','=','tbl_trx.customer_id')
        ->join('tbl_barang as b','b.id','=','tbl_trx.barang_id')
        ->join('tbl_vendor as v','b.vendor_id','=','v.id')
        ->select(DB::raw('c.username as customer,c.id as customer_id,b.nama as barang,b.id as barang_id, v.nama as vendor, v.id as vendor_id,tbl_trx.created_at as date,tbl_trx.cancel_reason'))
        ->paginate(10);
    }

    public static function trxSelesai($trx_id){
        $trx = Transaksi::where('id',$trx_id)->first();
        $trx->status = 1;
        $trx->save();
    }

    public function customer(){
        return $this->belongsTo('App\Customer');
    }

    public function barang(){
        return $this->belongsTo('App\Barang');
    }
}
