<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\Handler;
use App\Komentar;
use App\Rating;

class KomentarController extends Controller
{
    // KOMENTAR
    public function index($id){
        $komentar = Komentar::join('tbl_customer','tbl_komentar.customer_id','=','tbl_customer.id')->select('tbl_komentar.id','tbl_komentar.konten','tbl_customer.username','tbl_customer.avatar')->where('barang_id',$id)->get();
        if($komentar){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Komentar',
                'data' => $komentar,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Komentar tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'konten' => 'required',
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
            $komentar = new Komentar(array(
                'customer_id' => $request->customer_id,
                'barang_id' => $request->barang_id,
                'konten' => $request->konten,
            ));

            $rating = new Rating(array(
                'customer_id' => $request->customer_id,
                'barang_id' => $request->barang_id,
                'value' => $request->value,
            ));
            try{
                $komentar->save();
                $rating->save();
                // Response
                
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Komentar berhasil ditambahkan'
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

    public function update(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'komentar_id' => 'required|integer',
            'konten' => 'required',
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
            $komentar = Komentar::where('id',$request->komentar_id)->first();
            if($komentar){

                $komentar->konten = $request->konten;

                try{
                    $komentar->save();

                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Komentar diubah'
                    );
                }catch(\Exception $e){
                    $statusCode = 500;
                    $data = array(
                        'code' => '500',
                        'status' => 'error',
                        'message' => 'Komentar gagal diubah',
                    );
                }
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Komentar tidak ditemukan'
                );
            }
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function delete($id){
        $komentar = Komentar::where('id',$id)->first();
        if($komentar){
            $komentar->delete();
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Komentar Berhasil dihapus',
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Komentar tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    // RATING
    public function rating_store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'value' => 'required|integer',
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
            $rating = new Rating(array(
                'customer_id' => $request->customer_id,
                'barang_id' => $request->barang_id,
                'value' => $request->value,
            ));
            try{
                $rating->save();

                // Response
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Rating berhasil ditambahkan'
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

}
