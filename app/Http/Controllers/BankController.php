<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Validator;
use App\Bank;
use App\Rekening;

class BankController extends Controller
{

    // BANK CONFIGURATION
    public function bank_all(){
        $statusCode = 200;
        $data = array(
            'code' => '200',
            'status' => 'success',
            'message' => 'Daftar Bank',
            'data' => Bank::showAll()
        );
        return response()->json($data,$statusCode);
    }

    public function bank_store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'image' => 'required|string',
        ]);

        if ($validator->fails()) {
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors()->all(),
            );
        // Validation success
        }else{
            $bank = new Bank(array(
                'nama' => $request->nama,
                'image' => $request->image,
            ));

            try{
                $bank->save();

                // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Bank berhasil dibuat'
                    );
            }catch(\Exception $e){
                // Response
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

    public function bank_show($id){
        $bank = Bank::where('id',$id)->first();

        if($bank){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Bank',
                'data' => $bank,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Bank tidak ditemukan'
            );
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function bank_update(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors()->all(),
            );
        }else{
            $bank = Bank::where('id',$request->bank_id)->first();
            if($bank){
                try{
                    $bank->update(request()->all());

                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Bank berhasil diubah'
                    );
                }catch(\Exception $e){
                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'error_message' => $e,
                        'message' => 'Terjadi kesalahan pada sistem, silahkan diperiksa kembali',
                    );
                }
            }else{
                // Response
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data Bank tidak ditemukan'
                );
            }
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function bank_delete($id){
        $bank = Bank::where('id',$id);

        if($bank){
            $bank->delete();
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Bank Berhasil dihapus',
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Bank tidak ditemukan'
            );
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    // REKENING CONFIGURATION
    public function rekening_all(){
        $rekening = Rekening::all();

        if($rekening){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Rekening',
                'data' => $rekening,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Rekening tidak ditemukan'
            );
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function rekening_show($id){
        $rekening = Rekening::where('bank_id',$id)->first();

        if($rekening){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Rekening',
                'data' => $rekening,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Rekening tidak ditemukan'
            );
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function rekening_store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required|integer',
            'nama_pemilik' => 'required|string|max:50',
            'norek' => 'required|string',
        ]);

        if ($validator->fails()) {
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors()->all(),
            );
        // Validation success
        }else{
            $rekening = new Rekening(array(
                'bank_id' => $request->bank_id,
                'nama_pemilik' => $request->nama_pemilik,
                'norek' => $request->norek,
            ));

            try{
                $rekening->save();

                // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Rekening berhasil dibuat'
                    );
            }catch(\Exception $e){
                // Response
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

    public function rekening_update(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'rekening_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors()->all(),
            );
        }else{
            $rekening = Rekening::where('id',$id)->first();
            if($rekening){
                try{
                    $rekening->update(request()->all());

                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Rekening berhasil diubah'
                    );
                }catch(\Exception $e){
                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'error_message' => $e,
                        'message' => 'Terjadi kesalahan pada sistem, silahkan diperiksa kembali',
                    );
                }
            }else{
                // Response
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data Rekening tidak ditemukan'
                );
            }
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function rekening_delete($id){
        $rekening = Rekening::where('id',$id);

        if($rekening){
            $rekening->delete();
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Rekening Berhasil dihapus',
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Rekening tidak ditemukan'
            );
        }

        // Send Response
        return response()->json($data,$statusCode);
    }
}
