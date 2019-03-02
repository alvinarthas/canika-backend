<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Payment;
use App\Transaksi;
use App\Trxhistory;
use App\Notifikasi;
use App\KeteranganPayment;

class WebPayment extends Controller
{
    public function index(){
        $payment = Payment::all();

        return view('admin.payment.index',compact('payment'));
    }

    public function approvepayment($payment_id,$trx_id,$dp){
        $payment = Payment::where('id',$payment_id)->where('trx_id',$trx_id)->first();
            if($payment){
                try{
                    if($dp == 1){
                        $payment->status = 1;
                        $payment->save();

                        $trxhistory = New Trxhistory(array(
                            'trx_id' => $trx_id,
                            'status' => 4
                        ));
                        $trxhistory->save();
                            // notifikasi
                            $notifikasi1 = Notifikasi::addNotifikasi(1,$trx_id,14);
                            $notifikasi1 = Notifikasi::addNotifikasi(2,$trx_id,22);
                            $notifikasi1 = Notifikasi::addNotifikasi(2,$trx_id,18);
                            $notifikasi1 = Notifikasi::addNotifikasi(1,$trx_id,5);

                        $trxhistory2 = New Trxhistory(array(
                            'trx_id' => $trx_id,
                            'status' => 5
                        ));
                        $trxhistory2->save();
                            // notifikasi
                            $notifikasi1 = Notifikasi::addNotifikasi(1,$trx_id,2);
                            $notifikasi1 = Notifikasi::addNotifikasi(2,$trx_id,25);
                    }else{
                        $check = Trxhistory::where('trx_id',$trx_id)->where('status',3)->first();
                        $payment->status = 1;
                        $payment->save();
                        if($check){
                            $trxhistory = New Trxhistory(array(
                                'trx_id' => $trx_id,
                                'status' => 4
                            ));
                            $trxhistory->save();

                                // notifikasi
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$trx_id,14);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$trx_id,22);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$trx_id,18);
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$trx_id,5);

                            $trxhistory2 = New Trxhistory(array(
                                'trx_id' => $trx_id,
                                'status' => 8
                            ));
                            $trxhistory2->save();
                                // notifikasi
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$trx_id,6);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$trx_id,6);

                                // set status transaksi menjadi selesai
                                $setcomplete  = Transaksi::trxSelesai($trx_id);
                        }else{
                            $trxhistory = New Trxhistory(array(
                                'trx_id' => $trx_id,
                                'status' => 3
                            ));
                            $trxhistory->save();

                                // notifikasi
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$trx_id,13);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$trx_id,21);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$trx_id,17);
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$trx_id,4);

                            $trxhistory2 = New Trxhistory(array(
                                'trx_id' => $trx_id,
                                'status' => 5
                            ));
                            $trxhistory2->save();

                                // notifikasi
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$trx_id,2);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$trx_id,25);
                        }
                    }
                    
                    return redirect('getPayment');
                }catch(\Exception $e){
                    return redirect('getPayment');
                }
            }else{
                return redirect('getPayment');
            }
    }
}
