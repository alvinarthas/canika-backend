<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Vendor;
use App\Report;

class FreezeController extends Controller
{
    // update customer / vendor freeze status
    // show every customer freeze
    public function user_freeze(Request $request){
        $user_id = $request->user_id;
        $jenis = $request->jenis;

        if($jenis == 0){ // user
            $user = Customer::where('status',2)->paginate(10);
        }else{ // vendor
            $user = Vendor::where('status',2)->paginate(10);
        }

        if($user){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data User Freeze',
                'data' => $user,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'User Freeze tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }
    // show every vendor freeze
    public function status_update(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'jenis' => 'required|integer',
            'status' => 'required|integer',
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
            $jenis = $request->jenis;

            if($jenis == 0){ // user
                $user = Customer::where('id',$request->user_id)->first();
            }else{ // vendor
                $user = Vendor::where('id',$request->user_id)->first();
            }

            try{
                $user->status = $request->status;
                $user->save();
                // Response
                
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Status Freeze berhasil diubah'
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

        // Send Response
        return response()->json($data,$statusCode);
    }

    // REPORT USER LIST
    public function user_report(Request $request){
        $user_id = $request->user_id;
        $jenis = $request->jenis;

        $user = Report::getList($jenis);

        if(count($user) > 0 ){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data User Freeze',
                'data' => $user,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'User Freeze tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function report_detail(Request $request){
        $user_id = $request->user_id;
        $jenis = $request->jenis;

        $user = Report::getDetail($jenis,$user_id);

        if($user){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data User Freeze',
                'data' => $user,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'User Freeze tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function report_store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'jenis' => 'required|integer',
            'keterangan' => 'required',
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
            $report = new Report(array(
                'user_id' => $request->user_id,
                'jenis' => $request->jenis,
                'keterangan' => $request->keterangan
            ));

            try{
                $report->save();
                // Response
                
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Report berhasil ditambahkan'
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

        // Send Response
        return response()->json($data,$statusCode);
    }

    // BANNED
    public function user_ban(Request $request){
        $user_id = $request->user_id;
        $jenis = $request->jenis;

        if($jenis == 0){ // user
            $user = Customer::where('status',3)->paginate(10);
        }else{ // vendor
            $user = Vendor::where('status',3)->paginate(10);
        }

        if($user){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data User Banned',
                'data' => $user,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'User Banned tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

}
