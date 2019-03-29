<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Vendor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use App\Mail\SendMail;

class CustomerController extends Controller
{   
    // ADMIN
    public function index(){
        $customer = Customer::paginate(10);
        
        $statusCode = 200;
        $data = array(
            'code' => '200',
            'status' => 'success',
            'message' => 'Data customer telah ditemukan',
            'data' => $customer
        );
        return response()->json($data,$statusCode);
    }

    // USER
    public function customer_profile($id){
        // Find Customer by ID
            $customer = Customer::where('id',$id)->first();

        // Found
            if($customer){
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Data customer telah ditemukan',
                    'data' => $customer
                );
        // Not Found
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data customer tidak ditemukan',
                );
            }

            return response()->json($data,$statusCode);
    }

    public function customer_register(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:tbl_customer',
            'username' => 'required|string|max:50',
            'password' => 'required|min:8|confirmed',
            'hp' => 'required|string|max:14',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            // 'tanggal_lahir' => 'required|date|date_format:Y-m-d',
            // 'tempat_lahir' => 'required|string|max:50',
            'tanggal_nikah' => 'nullable|date|date_format:Y-m-d',
            'gender' => 'required',
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
            $customer = new Customer(array(
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'hp' => $request->hp,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tempat_lahir' => $request->tempat_lahir,
                'prov' => $request->prov,
                'kota' => $request->kota,
                'tanggal_nikah' => $request->tanggal_nikah,
                'avatar' => $request->avatar,
                'status' => 0,
                'verifyToken' => Str::random(40),
                'gender' => $request->gender,
            ));
            
            // success
            if($customer->save()){

                // Send Email Confirmation 
                $this->sendEmail($customer);

                // Response
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Customer Berhasil dibuat, silahkan cek Email Anda di '.$request->email.' '
                );
            // fail
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Customer gagal dibuat',
                );
            }
        }

        // Send Response
        return response()->json($data,$statusCode);
    }

    public function sendEmail($customer){
        $data = array(
            'email' => $customer->email,
            'route' => 'customerVerify',
            'verifyToken' => $customer->verifyToken
        );
        Mail::send('mail.verifyEmail',$data, function($message) use ($data){
            $message->to($data['email']);
            $message->subject('Customer Register');
        });
    }

    public function customer_verify($email,$verifyToken){
        $customer = Customer::where(['email'=>$email,"verifyToken"=>$verifyToken])->first();
        if($customer){
            Customer::verifyAccount($email,$verifyToken);
            // Go To Page Succes
            // return redirect('/')->with('status', 'Selamat!!! Akun anda telah diverifikasi. Silahkan masuk dengan akun anda.');
        }else{
            // Go To Page Failed
            // return redirect('/')->with('status', 'Terjadi Kesalahan pada Verifikasi Akun anda');
        }
    }

    public function customer_login(Request $request){
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
            $customer = Customer::where('email',$request->email)->where('status',1)->first();
            // FOUND
            if($customer && Hash::check($request->password, $customer->password)){
                $statusCode = 200;
                $data = array(
                    'code' => '200',
                    'status' => 'success',
                    'message' => 'Data customer telah ditemukan',
                    'data' => $customer
                );
            
            // NOT FOUND 
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data customer tidak ditemukan, username/password anda salah!!!',
                );
            }

            return response()->json($data,$statusCode);
        }
    }

    

    // Update Profil, yang tidak bisa diubah cuman email, no hp, password
    public function customer_update(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
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
            $customer = Customer::where('id',$request->user_id)->first();

            // FOUND
            if($customer){
                try{

                    $customer->update(request()->all());

                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Customer berhasil diubah'
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
            $customer = Customer::where('email',$request->email_lama);

            // FOUND
            if($customer->row() == 1){
                $customer = $customer->first();

                $customer->email = $request->email_baru;

                // success
                if($customer->save()){

                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Ubah Email berhasil diubah'
                    );

                // fail
                }else{
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
            $customer = Customer::where('hp',$request->no_hp_lama);

            // FOUND
            if($customer->row() == 1){
                $customer = $customer->first();

                $customer->hp = $request->no_hp_baru;

                // success
                if($customer->save()){

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
                $message->subject('Forget Customer Email');
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
            $customer = Customer::where('email',$request->email)->where('status',1)->first();
            $customer->password = Hash::make($request->password);
            $customer->save();
            
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
}
