<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Trxhistory;
use App\Status;

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

    public function editTrx(Request $request){
        $transaksi = Transaksi::where('id',$request->id)->first();
        $status = Status::where('jenis','transaksi')->get();
        return view('admin.transaksi.form',compact('jenis','transaksi','status'));
    }

    public function updateTrx(Request $request){
        $transaksi = Transaksi::where('id',$request->transaksi_id)->first();
        try{
            $transaksi->update(request()->all());

            return redirect()->route('getTransaksi');
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e);
        }
    }
}
