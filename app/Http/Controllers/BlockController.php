<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Validator;
use App\Block;

class BlockController extends Controller
{
    public function listBlock(Request $request){
        // Find Customer by ID
        $block = Block::where('customer_id',$request->customer_id)->first();

        // Found
            if($block){
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Data Vendor yang diblock telah ditemukan',
                    'data' => $block
                );
        // Not Found
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data Vendor yang diblock tidak ditemukan',
                );
            }

            return response()->json($data,$statusCode);
    }

    public function vendorBlock(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'vendor_id' => 'required|integer',
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
            $block = new Block(array(
                'customer_id' => $request->customer_id,
                'vendor_id' => $request->vendor_id,
            ));

            try{
                $block->save();

                // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Vendor berhasil diblock'
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

    public function deleteBlock(Request $request){
        $block = Block::where('customer_id',$request->customer_id)->where('vendor_id',$request->vendor_id)->first();

        if($block){
            $block->delete();
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Berhasil dihapus',
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            );
        }

        // Send Response
        return response()->json($data,$statusCode);
    }
}
