<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Vendor;
use App\Notifikasi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use App\Mail\SendMail;

class UserController extends Controller
{
    public function user_login(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'jenis' => 'required',
        ]);

        // IF Validation fail
        if ($validator->fails()) {
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors(),
            );
        // Validation success
        }else{
            // 0 = customer
            // 1 = vendor
            if($request->jenis == 0){
                // Check data
                $user = Customer::where('email',$request->email)->where('status',1)->first();
            }else{
                // Check data
                $user = Vendor::where('email',$request->email)->where('status',1)->first();
            }
            
            // FOUND
            if($user && Hash::check($request->password, $user->password)){
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Data User telah ditemukan',
                    'data' => $user
                );
            
            // NOT FOUND 
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data User tidak ditemukan, username/password anda salah!!!',
                );
            }

            return response()->json($data,$statusCode);
        }
    }

    public function user_active(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'jenis' => 'required',
        ]);

        // IF Validation fail
        if ($validator->fails()) {
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors(),
            );
        // Validation success
        }else{
            // 0 = customer
            // 1 = vendor
            if($request->jenis == 0){
                $user = Customer::where('id',$request->user_id)->first();
            }else{
                $user = Vendor::where('id',$request->user_id)->first();
            }

            try{
                $user->touch();
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Data User telah diupdate',
                );
            }catch(\Exception $e){
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'error_message' => $e,
                    'message' => 'Terjadi kesalahan pada sistem, silahkan diperiksa kembali',
                );
            }
        }
        return response()->json($data,$statusCode);
    }
    
    public function test(){
        return Notifikasi::addNotifikasi(1,5,1);
    }

    public function user_notif(Request $request){
        $user = $request->user_id;
        $jenis = $request->jenis;

        // customer
        $notif = Notifikasi::getNotif($jenis,$user);

        $statusCode = 200;
        $data = array(
            'code' => '200',
            'status' => 'success',
            'message' => 'Data Notifikasi',
            'data' => $notif
        );

        // Send Response
        return response()->json($data,$statusCode);
        
    }

    public function read_notif(Request $request){
        $notif_id = $request->notif_id;

        $notifikasi = Notifikasi::where('id',$notif_id)->first();

        $notifikasi->read = 1;
        try{
            $notifikasi->save();

            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Notifikasi Berhasil dibaca',
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

        // Send Response
        return response()->json($data,$statusCode);    
    }
}
