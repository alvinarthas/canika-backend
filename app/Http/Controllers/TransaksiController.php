<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Transaksi;
use App\Trxhistory;
use App\Wishlist;
use App\Rating;
use App\Notifikasi;
use App\Exceptions\Handler;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    //  TRANSAKSI
    public function list_customer(Request $request){
        $customer = $request->customer_id;
        $transaksi = Transaksi::trxCustomer($customer);
        if(count($transaksi) > 0){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Daftar Transaksi',
                'data' => $transaksi
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Transaksi Customer tidak ditemukan'
            );
        }
        
        return response()->json($data,$statusCode);
    }

    public function history(Request $request){
        $customer = $request->customer_id;
        $transaksi = Transaksi::trxHistory($customer);

        $statusCode = 200;
        $data = array(
            'code' => '200',
            'status' => 'success',
            'message' => 'Daftar Transaksi History',
            'data' => $transaksi
        );

        return response()->json($data,$statusCode);
    }

    public function detail($id){
        $transaksi = Transaksi::trxCustomerdet($id);
        if($transaksi){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Transaksi Customer',
                'data' => $transaksi,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Transaksi Customer tidak ditemukan'
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
            'harga' => 'required|integer',
            'dp_status' => 'required|integer',
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
            $transaksi = new Transaksi(array(
                'customer_id' => $request->customer_id,
                'barang_id' => $request->barang_id,
                'harga' => $request->harga,
                'status' => 0,
                'dp_status' => $request->dp_status,
                'dp_persen' => $request->dp_persen,
            ));
            try{
                $transaksi->save();
                // Response

                
                //lunas
                if($request->dp_status == 1){
                    // Transaksi History
                    $trxhistory = new Trxhistory(array(
                        'trx_id' => $transaksi->id,
                        'status' => 7,
                        'max_date' => Carbon::now()->addDays(3),
                    ));

                    $trxhistory->save();

                    // Set Notification
                    $notifikasi1 = Notifikasi::addNotifikasi(1,$transaksi->id,10);
                    $notifikasi1 = Notifikasi::addNotifikasi(2,$transaksi->id,16);
                // dp
                }elseif($request->dp_status == 0){
                    // Transaksi History
                    $trxhistory = new Trxhistory(array(
                        'trx_id' => $transaksi->id,
                        'status' => 1,
                        'max_date' => Carbon::now()->addDays(3),
                    ));

                    $trxhistory->save();

                    // Set Notification
                    $notifikasi1 = Notifikasi::addNotifikasi(1,$transaksi->id,9);
                    $notifikasi1 = Notifikasi::addNotifikasi(2,$transaksi->id,15);
                }
                
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Transaksi Berhasil dicatat',
                    'data' => $transaksi->id
                    );
            }catch(\Exception $e){
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status ' => 'error',
                    'message' => $e,
                );
            }
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function delete(Request $request, $id){
        $cancel_reason = $request->cancel_reason;
        $cancel_by = $request->cancel_by;
        $transaksi = Transaksi::where('id',$id)->first();
        if($transaksi){
            $transaksi->status = 99;
            $transaksi->cancel_reason = $cancel_reason;
            $transaksi->cancel_by = $cancel_by;

            $transaksi->save();

            // notifikasi
            $notifikasi1 = Notifikasi::addNotifikasi($cancel_by,$transaksi->id,1);

            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Transaksi Berhasil dihapus',
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Transaksi tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function awal(Request $request){
        $customer = $request->customer_id;
        $barang = $request->barang_id;

        $trx = Transaksi::awal($barang,$customer);
        if($trx){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Transaksi Customer',
                'data' => $trx,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Transaksi Customer tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    // TRANSAKSI HISTORY

    public function trxhistory_all($id){
        $trxhistory = Trxhistory::where('trx_id',$id)->get();
        if($trxhistory){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Transaksi History Customer',
                'data' => $trxhistory,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Transaksi History tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function trxhistory_status(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'trx_id' => 'required|integer',
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
            $trxhistory = new Trxhistory(array(
                'trx_id' => $request->trx_id,
                'status' => $request->status,
            ));
            try{
                $trxhistory->save();
                // Response

                if($request->status == 6){
                    // notifikasi
                    $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,3);
                    $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,26);
                }elseif ($request->status == 7) {
                    // notifikasi
                    $notifikasi1 = Notifikasi::addNotifikasi(1,$request->trx_id,10);
                    $notifikasi1 = Notifikasi::addNotifikasi(2,$request->trx_id,16);
                }
    
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Keterangan Transaksi Berhasil ditambah'
                );
            }catch(\Exception $e){
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => $e,
                );
            }
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function trxhistory_update(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'trxhistory_id' => 'required|integer',
            'status' => 'required'
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
            $trxhistory = Trxhistory::where('id',$request->trxhistory_id)->first();
            if($trxhistory){

                $trxhistory->status = $request->status;

                try{
                    $trxhistory->save();
                    // Response

                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Transaksi Keterangan telah diubah'
                    );
                }catch(\Exception $e){
                    $statusCode = 500;
                    $data = array(
                        'code' => '500',
                        'status' => 'error',
                        'message' => $e,
                    );
                }
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Transaksi Keterangan tidak ditemukan'
                );
            }
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function trxhistory_delete($id){
        $trxhistory = Trxhistory::where('id',$id)->first();
        if($trxhistory){
            $trxhistory->delete();
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Transaksi History dihapus',
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Transaksi History tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }


    // WISHLIST

    public function wishlist_all($id){
        // Based on customer
        $wishlist = Wishlist::getWishlist($id);
        $all_wish = collect();
        if($wishlist->count() > 0){
            foreach($wishlist as $wish){
                $wish_collect = collect($wish);
                $rating = Rating::getRating($wish->id);
                if(count($rating) > 0){
                    $rate = $rating[0]->rate;
                }else{
                    $rate = 0;
                }
                $wish_collect->put('rate',$rate);
                $all_wish->push($wish_collect);
            }
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Wishlist Customer',
                'data' => $all_wish,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Transaksi Customer tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function wishlist_store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|integer',
            'barang_id' => 'required|integer',
        ]);

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
            $wishlist = new Wishlist(array(
                'customer_id' => $request->customer_id,
                'barang_id' => $request->barang_id,
                'status' => 1,
            ));
            
            // success
            if($wishlist->save()){
                // Response
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Wishlist Berhasil ditambah'
                );
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Wishlist gagal ditambah',
                );
            }
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function wishlist_delete(Request $request){
        $wishlist_id = $request->wishlist_id;

        $wishlist = Wishlist::where('id',$wishlist_id)->where('status',1);
        if($wishlist){
            $wishlist->delete();
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Wishlist Berhasil dihapus',
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Wishlist tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function wishlist_filter(Request $request){
        $kat = $request->kat_id;
        $customer = $request->customer_id;

        $result = Wishlist::filter($kat,$customer);

        if($result){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Daftar Wishlist ditemukan',
                'data' => $result
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'gagal',
                'message' => 'Daftar Wishlist tidak ditemukan'
            );
        }

        return response()->json($data,$statusCode);
    }

    // ADMIN TRANSAKSI
    public function trx_list(){
        $transaksi = Transaksi::listTrx();
        if(count($transaksi) > 0 ){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Transaksi Customer',
                'data' => $transaksi,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Transaksi Customer tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }
}
