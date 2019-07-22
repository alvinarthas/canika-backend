<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;
use App\Status;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use App\Mail\SendMail;

class WebVendor extends Controller
{
    public function index(){
        $vendor = Vendor::all();

        return view('admin.vendor.index',compact('vendor'));
    }

    public function create(){
        $jenis = "create";
        return view('admin.vendor.form',compact('jenis'));
    }

    public function store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:tbl_vendor',
            'password' => 'required|min:8|confirmed',
            'hp' => 'required|string|max:14',
            'nama' => 'required|string|max:50',
            'alamat' => 'required',
            'email_perusahaan' => 'required',
        ]);
        // IF Validation fail
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        // Validation success
        }else{
            $vendor = new Vendor(array(
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'hp' => $request->hp,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'email_perusahaan' => $request->email_perusahaan,
                'website' => $request->website,
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
                return redirect()->route('getVendor');
                // Response
            }catch(\Exception $e){
                return redirect()->back()->withErrors($e);
            }
        }
    }

    public function edit($id){
        $jenis = "edit";
        $vendor = Vendor::where('id',$id)->first();
        $status = Status::where('jenis','vendor')->get();
        return view('admin.vendor.form',compact('jenis','vendor','status'));
    }

    public function update(Request $request, $id){
        $vendor = Vendor::where('id',$request->vendor_id)->first();
        try{
            $vendor->update(request()->all());

            return redirect()->route('getVendor');
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e);
        }
    }

    public function delete($id){

    }

    public function vendor_verify(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|unique:tbl_vendor',
            'status' => 'required|number',
            'verifyConfirmation' => 'string',
        ]);
        // IF Validation fail
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
            $vendor = Vendor::where('id',$request->vendor_id)->first();
            if($request->status == 1){
                $vendor->verifyConfirmation = "Congratulory Message";
            }else{
                $vendor->verifyConfirmation = "Rejection Message";
            }
                $vendor->status = $request->status;    
                $vendor->save();
                // Send Email Confirmation 
                $this->sendEmail($vendor);
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
}
