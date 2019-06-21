<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Nego;
use App\Customer;
use App\Barang;
use Mail;

class NegoController extends Controller
{
    public function index(){
        $statusCode = 200;
        $data = array(
            'code' => '200',
            'status' => 'success',
            'message' => 'Daftar Nego Harga',
            'data' => Nego::all()
        );
        return response()->json($data,$statusCode);
    }

    public function store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'harga' => 'required|integer',
            'tgl_booking' => 'required|date',
        ]);
        if ($validator->fails()) {
            // IF Validation fail

            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors()->all(),
            );

        }else{
            $nego = new Nego(array(
                'customer_id' => $request->customer_id,
                'barang_id' => $request->barang_id,
                'harga' => $request->harga,
                'tgl_booking' => $request->tgl_booking,
            ));
            if($nego->save()){
                // Response
                
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Nego Berhasil diajukan, Status masih pending'
                );
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Nego gagal diajukan',
                );
            }
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function detail($id){
        $nego = Nego::where('id',$id);
        if($nego){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Pengajuan Nego Customer',
                'data' => $nego->first(),
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Pengajuan Nego tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function approve(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'nego_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            // IF Validation fail

            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors()->all(),
            );

        }else{
            $nego = Nego::where('id',$request->nego_id)->first();
            if($nego){

                $nego->status = "Approve";

                // success
                if($nego->save()){
                    // Get Email
                    $email_customer = Customer::where('id',$nego->customer_id)->first()->email;
                    $barang = Barang::where('id',$nego->barang_id)->first()->nama;

                    // Send Email
                    $data = array(
                        'email' => $email_customer,
                        'barang' => $barang,
                        'harga' => $nego->harga,
                    );
                    
                    Mail::send('mail.approveNego',$data, function($message) use ($data){
                        $message->to($data['email']);
                        $message->subject('Approval Nego Harga');
                    });

                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Status Nego telah di approve, email telah dikirim ke'
                    );
                }else{
                    $statusCode = 500;
                    $data = array(
                        'code' => '500',
                        'status' => 'error',
                        'message' => 'Status Nego gagal diubah',
                    );
                }
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data Nego tidak ditemukan'
                );
            }
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function check(Request $request){
        $customer = $request->customer;
        $barang = $request->barang;

        $check = Nego::where('barang_id',$barang)->where('customer_id',$customer)->first();
        if($check){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Nego Customer',
                'data' => $check
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Nego tidak ditemukan'
            );
        }

        // Send Response
        return response()->json($data,$statusCode);
    }
}
