<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Payment;
use App\Transaksi;
use App\Trxhistory;
use App\Notifikasi;
use App\KeteranganPayment;

class PaymentController extends Controller
{
    public function keterangan_payment(){
        $statusCode = 200;
        $data = array(
            'code' => '200',
            'status' => 'success',
            'message' => 'Daftar Keterangan Payment',
            'data' => KeteranganPayment::all()
        );
        return response()->json($data,$statusCode);
    }
    public function awal(Request $request){
        $trx_id = $request->trx_id;
        $awalan = Transaksi::paymentAwal($trx_id);
        if(count($awalan) > 0){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Daftar Konfirmasi Transaksi',
                'data' => $awalan
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Konfirmasi Transaksi tidak ditemukan'
            );
        }
        
        return response()->json($data,$statusCode);
    }

    public function check(Request $request){
        $payment_id = $request->payment_id;
        $check = Payment::where('id',$payment_id)->first();
        if($check){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Daftar Konfirmasi Transaksi',
                'data' => $check
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Konfirmasi Transaksi tidak ditemukan'
            );
        }
        
        return response()->json($data,$statusCode);
    }

    public function awalxx(Request $request){
        $trx_id = $request->trx_id;
        $awalan = Transaksi::awalan($trx_id);
        if($awalan){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Daftar Konfirmasi Transaksi',
                'data' => $awalan
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Konfirmasi Transaksi tidak ditemukan'
            );
        }
        
        return response()->json($data,$statusCode);
    }

    public function konfirmasi(Request $request){
        $trx_id = $request->trx_id;
        $konfirmasi = Transaksi::konfirmasiPayment($trx_id);
        if($konfirmasi){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Daftar Konfirmasi Transaksi',
                'data' => $konfirmasi
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Konfirmasi Transaksi tidak ditemukan'
            );
        }
        
        return response()->json($data,$statusCode);
    }

    public function payment_bank(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'trx_id' => 'required|integer',
            'bank' => 'required|integer',
        ]);
        if ($validator->fails()) {
            // IF Validation fail

            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors(),
            );

        }else{
            $payment = new Payment(array(
                'trx_id' => $request->trx_id,
                'bank' => $request->bank,
                'status' => 0,
                'method' => 0,
            ));
            try{
                $payment->save();
                // Response

                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Pemilihan Bank Berhasil dicatat'
                    );
            }catch(\Exception $e){
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status ' => 'error',
                    'error_message' => $e,
                    'message' => 'Terjadi kesalahan pada sistem, silahkan diperiksa kembali',
                );
            }
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function payment_upload(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required|integer',
            'trx_id' => 'required|integer',
            'nama_pengirim' => 'required',
            'bank_pengirim' => 'required',
            'tgl_trf' => 'required|date',
            'bukti_bayar' => 'required',
        ]);
        if ($validator->fails()) {
            // IF Validation fail

            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors(),
            );

        }else{
            $payment = Payment::where('id',$request->payment_id)->where('trx_id',$request->trx_id)->first();
            if($payment){        
                try{
                    $payment->update(request()->all());
                   
                    $trx = Transaksi::where('id',$request->trx_id)->first();
                    // Transaksi History
                    $trxhistory = new Trxhistory(array(
                        'trx_id' => $request->trx_id,
                        'status' => 2,
                    ));

                    $trxhistory->save();

                    if($trx->dp_status == 1){
                        $notifikasi1 = Notifikasi::addNotifikasi(1,$trx->id,12);
                        $notifikasi1 = Notifikasi::addNotifikasi(2,$trx->id,20);
                    }elseif ($trx->dp_status == 0) {
                        $notifikasi1 = Notifikasi::addNotifikasi(1,$trx->id,11);
                        $notifikasi1 = Notifikasi::addNotifikasi(2,$trx->id,19);
                    }

                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Upload Bukti Bayar Berhasil dicatat'
                    );
                }catch(\Exception $e){
                    $statusCode = 500;
                    $data = array(
                        'code' => '500',
                        'status ' => 'error',
                        'error_message' => $e,
                        'message' => 'Terjadi kesalahan pada sistem, silahkan diperiksa kembali',
                    );
                }
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Data Payment tidak ditemukan'
                );
            }
            
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function vendor_approvepayment(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required|integer',
            'trx_id' => 'required|integer',
            'dp_status' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors(),
            );
        }else{
            $payment = Payment::where('id',$request->payment_id)->where('trx_id',$request->trx_id)->first();
            if($payment){
                try{
                    if($request->dp_status == 1){
                        $payment->status = 1;
                        $payment->save();

                        $trxhistory = New Trxhistory(array(
                            'trx_id' => $request->trx_id,
                            'status' => 4
                        ));
                        $trxhistory->save();
                            // notifikasi
                            $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,14);
                            $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,22);
                            $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,18);
                            $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,5);

                        $trxhistory2 = New Trxhistory(array(
                            'trx_id' => $request->trx_id,
                            'status' => 5
                        ));
                        $trxhistory2->save();
                            // notifikasi
                            $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,2);
                            $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,25);
                    }else{
                        $check = Trxhistory::where('trx_id',$request->trx_id)->where('status',3)->first();
                        $payment->status = 1;
                        $payment->save();
                        if($check){
                            $trxhistory = New Trxhistory(array(
                                'trx_id' => $request->trx_id,
                                'status' => 4
                            ));
                            $trxhistory->save();

                                // notifikasi
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,14);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,22);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,18);
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,5);

                            $trxhistory2 = New Trxhistory(array(
                                'trx_id' => $request->trx_id,
                                'status' => 8
                            ));
                            $trxhistory2->save();
                                // notifikasi
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,6);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,6);

                                // set status transaksi menjadi selesai
                                $setcomplete  = Transaksi::trxSelesai($request->trx_id);
                        }else{
                            $trxhistory = New Trxhistory(array(
                                'trx_id' => $request->trx_id,
                                'status' => 3
                            ));
                            $trxhistory->save();

                                // notifikasi
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,13);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,21);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,17);
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,4);

                            $trxhistory2 = New Trxhistory(array(
                                'trx_id' => $request->trx_id,
                                'status' => 5
                            ));
                            $trxhistory2->save();

                                // notifikasi
                                $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,2);
                                $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,25);
                        }
                    }
                    
                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Payment berhasil diapprove'
                    );
                }catch(\Exception $e){
                    $statusCode = 500;
                    $data = array(
                        'code' => '500',
                        'status' => 'error',
                        'message' => "$e",
                    );
                }
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data Barang/Jasa tidak ditemukan'
                );
            }
        }
        // Send Response
        return response()->json($data,$statusCode);
    }
}
