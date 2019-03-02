<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Trxhistory;

class WebTransaksi extends Controller
{
    public function index(){
        $transaksi = Transaksi::all();

        return view('admin.transaksi.index',compact('transaksi'));
    }
    
    public function showhistory(Request $request){
        $trxhistory = Trxhistory::where('trx_id',$request->id)->get();
        return view('admin/transaksi/modal-history',compact('trxhistory'));

    }
}
