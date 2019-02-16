<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use Illuminate\Http\Request;
use App\Vendor;
use App\Barang;
use App\Rating;
use App\Wishlist;
use App\Transaksi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Mail;

class VendorController extends Controller
{
    public function index(){
        $vendor = Vendor::paginate(10);
        
        $statusCode = 200;
        $data = array(
            'code' => '200',
            'status' => 'success',
            'message' => 'Data customer telah ditemukan',
            'data' => $vendor
        );
        return response()->json($data,$statusCode);
    }

    public function vendor_register(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:tbl_vendor',
            'password' => 'required|min:8|confirmed',
            'hp' => 'required|string|max:14',
            'nama' => 'required|string|max:50',
            'alamat' => 'required',
            'email_perusahaan' => 'required|email',
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
            $vendor = new Vendor(array(
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'hp' => $request->hp,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'kode_pos' => $request->kode_pos,
                'contact_person' => $request->contact_person,
                'jabatan' => $request->jabatan,
                'email_perusahaan' => $request->email_perusahaan,
                'website' => $request->website,
                'bank' => $request->bank,
                'no_rek' => $request->no_rek,
                'pemilik_rek' => $request->pemilik_rek,
                'cabang_bank' => $request->cabang_bank,
                'prov' => $request->prov,
                'kota' => $request->kota,
                'avatar' => $request->avatar,
                'status' => 0,
                'email_konf' => 0,
                'sms_konf' => 0,
                'verifyToken' => Str::random(40),
            ));
            
            try{
                $vendor->save();

                // Send Email Confirmation 
                $this->sendEmail($vendor);

                // Response
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Vendor Berhasil dibuat, silahkan cek Email Anda di '.$request->email.' '
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

    public function vendor_profile($id){
        // Find Customer by ID
            $vendor = Vendor::where('id',$id)->first();

        // Found
            if($vendor){
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Data vendor telah ditemukan',
                    'data' => $vendor
                );
        // Not Found
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data vendor tidak ditemukan',
                );
            }

            return response()->json($data,$statusCode);
    }

    // Update Profil, yang tidak bisa diubah cuman email, no hp, password
    public function vendor_update(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|integer',
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
            $vendor = Vendor::where('id',$request->vendor_id)->first();

            // FOUND
            if($vendor){
                try{

                    $vendor->update(request()->all());

                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Vendor berhasil diubah'
                    );
                    

                }catch(\Exception $e){

                    $statusCode = 500;
                    $data = array(
                        'code' => '500',
                        'status' => 'error',
                        'message' => $e,
                    );
                }
            
            // NOT FOUND 
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data customer tidak ditemukan, username/password anda salah!!!',
                );
            }
        }

        return response()->json($data,$statusCode);
    }

    public function vendor_login(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
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
            // Check data
            $vendor = Vendor::where('email',$request->email)->where('status',1)->first();
            // FOUND
            if($vendor && Hash::check($request->password, $vendor->password)){
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Data vendor telah ditemukan',
                    'data' => $vendor
                );
            
            // NOT FOUND 
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data vendor tidak ditemukan, username/password anda salah!!!',
                );
            }

            return response()->json($data,$statusCode);
        }
    }

    // KONFIRMASI
    public function sendEmail($vendor){
        $data = array(
            'email' => $vendor->email,
            'route' => 'vendorVerify',
            'verifyToken' => $vendor->verifyToken
        );
        Mail::send('mail.verifyEmail',$data, function($message) use ($data){
            $message->to($data['email']);
            $message->subject('Vendor Register');
        });
    }

    public function vendor_verify($email,$verifyToken){
        $vendor = Vendor::where(['email'=>$email,"verifyToken"=>$verifyToken])->first();
        if($vendor){
            Vendor::verifyAccount($email,$verifyToken);
            // Go To Page Succes
            // return redirect('/')->with('status', 'Selamat!!! Akun anda telah diverifikasi. Silahkan masuk dengan akun anda.');
        }else{
            // Go To Page Failed
            // return redirect('/')->with('status', 'Terjadi Kesalahan pada Verifikasi Akun anda');
        }
    }

    public function vendor_sms(){
        $nexmo = app('Nexmo\Client');

        $nexmo->message()->send([
            'to'   => '6282216418599',
            'from' => '6287722044120',
            'text' => 'Testing SMS Canika'
        ]);
    }

    public function email_update(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'email_lama' => 'required|email',
            'email_baru' => 'required|email',
            'password' => 'required|min:8',
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
            $vendor = Vendor::where('email',$request->email_lama);

            // FOUND
            if($vendor->row() == 1){
                $vendor = $vendor->first();

                $vendor->email = $request->email_baru;

                try{
                    $vendor->save();

                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Ubah Email berhasil diubah'
                    );

                }catch(\Exception $e){
                    $statusCode = 500;
                    $data = array(
                        'code' => '500',
                        'status' => 'error',
                        'message' => 'Ubah Email gagal diubah',
                    );
                }
            
            // NOT FOUND 
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data customer tidak ditemukan',
                );
            }
        }

        return response()->json($data,$statusCode);
    }

    public function hp_update(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'no_hp_lama' => 'required',
            'no_hp_baru' => 'required',
            'password' => 'required|min:8',
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
            $vendor = Vendor::where('hp',$request->no_hp_lama);

            // FOUND
            if($vendor->row() == 1){
                $vendor = $vendor->first();

                $vendor->hp = $request->no_hp_baru;

                // success
                if($vendor->save()){

                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Ubah No Hp berhasil diubah'
                    );

                // fail
                }else{
                    $statusCode = 500;
                    $data = array(
                        'code' => '500',
                        'status' => 'error',
                        'message' => 'Ubah No Hp gagal diubah',
                    );
                }
            
            // NOT FOUND 
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data customer tidak ditemukan',
                );
            }
        }

        return response()->json($data,$statusCode);
    }

    public function forget_password_link(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
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
            $datasend = array(
                'email' => $request->email
            );
            Mail::send('mail.forgetPass',$datasend, function($message) use ($datasend){
                $message->to($datasend['email']);
                $message->subject('Forget Vendor Email');
            });

            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Silahkan cek email anda di '.$request->email.'. Terima Kasih'
            );
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function reset_password_link(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
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
            // Check data
            $vendor = Vendor::where('email',$request->email)->where('status',1)->first();
            $vendor->password = Hash::make($request->password);
            $vendor->save();
            
            // SEND CONFIRMATION
            $datasend = array(
                'email' => $request->email
            );
            Mail::send('mail.confirmReset',$datasend, function($message) use ($datasend){
                $message->to($datasend['email']);
                $message->subject('Confirmation Reset Passsword Customer');
            });
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Silahkan cek email anda di '.$request->email.'. Terima Kasih'
            );
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function get_barang(Request $request){
        $id = $request->vendor;
        $status = $request->status;
        $customer = $request->customer;

        $vendor = Vendor::where('id',$id)->first();
        if($vendor){
            $barang = collect();
            if($status!=NULL){
                $getbrg = $vendor->barang()->where('status',$status)->get();
            }else{
                $getbrg = $vendor->barang()->get();
            }
            foreach($getbrg as $brg){
                $brrg = collect($brg);
                $rating = Rating::getRating($brg->id);
                $image = $brg->gallery()->first()->image;
                if(!$rating){
                    $brrg->put('rate',$rating[0]->rata);
                }else{
                    $brrg->put('rate',0);
                }
                $brrg->put('image',$image);
                if($customer > 0){
                    $checkwishlist = Wishlist::checkWishlist($brg->id,$customer);
                    if($checkwishlist > 0){
                        $wishlist_id = Wishlist::where('barang_id',$brg->id)->where('customer_id',$customer)->first()->id;
                        $brrg->put('wishlist',1);
                        $brrg->put('wishlist_id',$wishlist_id);
                    }else{
                        $brrg->put('wishlist',0);
                    }
                }else{
                    $brrg->put('wishlist',999);
                }
                $barang->push($brrg);
            }    
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Barang Vendor telah ditemukan',
                'data' => $barang
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Barang Vendor tidak ditemukan',
            );
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function vendor_category($id){
        // Find Customer by ID
        $vendor = Vendor::getCategory($id);
        $ven_collect = collect();
        foreach($vendor as $ven){
            $rating = Vendor::getRating($ven->id);
            
            $array = array(
                'id' =>$ven->id,
                'nama' => $ven->nama,
                'avatar'=> $ven->avatar,
                'deskripsi' => $ven->deskripisi,
                'rata' => $rating[0]->rata,
            );

            $ven_collect->push($array);
        }
        // Found
            if($ven_collect){
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Data vendor telah ditemukan',
                    'data' => $ven_collect
                );
        // Not Found
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data vendor tidak ditemukan',
                );
            }

            return response()->json($data,$statusCode);
    }

    public function vendor_search(Request $request){
        $param = $request->param;

        $result = Vendor::searchVendor($param);

        if($result){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Daftar Barang/Jasa ditemukan',
                'data' => $result
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'gagal',
                'message' => 'Daftar Barang/Jasa tidak ditemukan'
            );
        }

        return response()->json($data,$statusCode);
    }

    public function vendor_popular(){
        $vendor = Rating::getPopularVendor();
        if($vendor){
        $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Barang/Jasa Popular',
                'data' => $vendor,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Barang/Jasa tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function vendor_filter(Request $request){
        $harga1 = $request->harga1;
        $harga2 = $request->harga2;
        $rating = $request->rating;
        $kategori = $request->kategori;
        $search = $request->search;

        if($search){
            if($harga1||$harga2||$rating||$kategori){
                // api filter with search param
                $rate = Rating::filterRatingSearch($harga1,$harga2,$rating,$kategori,$search);
            }else{
                // api search
                $rate = Vendor::searchVendor($search);
            }
        }else{
            $rate = Rating::filterRating($harga1,$harga2,$rating,$kategori);
        }
        

        if($rate){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Filter Vendor',
                'data' => $rate,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Barang/Jasa tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function vendor_filter2(Request $request){
        $harga1 = $request->harga1;
        $harga2 = $request->harga2;
        $rating = $request->rating;
        $kategori = $request->kategori;
        $search = $request->search;
        $rate = Rating::filterRating($harga1,$harga2,$rating,$kategori,$search);

        if($rate){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Vendor Popular',
                'data' => $rate,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Barang/Jasa tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function vendor_trx(Request $request){
        $vendor = $request->vendor_id;
        $status = $request->status;

        $transaksi = Transaksi::trxVendor($vendor,$status);
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

}
