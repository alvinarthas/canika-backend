<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Vendor;
use App\Status;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use App\Mail\SendMail;

class WebCustomer extends Controller
{
    public function index(Request $request){

        $customer = Customer::all();

        return view('admin.customer.index',compact('customer'));
    }

    public function create(){
        $jenis = "create";
        return view('admin.customer.form',compact('jenis'));
    }

    public function store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:tbl_customer',
            'username' => 'required|string|max:50',
            'password' => 'required|min:8|confirmed',
            'hp' => 'required|string|max:14',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'tanggal_nikah' => 'nullable|date|date_format:Y-m-d',
            'gender' => 'required',
        ]);
        // IF Validation fail
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
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

                return redirect()->route('getCustomer');
            // fail
            }else{
                return redirect()->back()->withErrors($e);
            }
        }
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

    public function edit($id){
        $jenis = "edit";
        $customer = Customer::where('id',$id)->first();
        $status = Status::where('jenis','customer')->get();
        return view('admin.customer.form',compact('jenis','customer','status'));
    }

    public function update(Request $request, $id){
        $customer = Customer::where('id',$request->customer_id)->first();
        try{
            $customer->update(request()->all());

            return redirect()->route('getCustomer');
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e);
        }
    }

    public function getChangePass(Request $request){
        $email = $request->email;
        return view('mail.resetpassword',compact('email'));
    }

    public function storeChangePass(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // IF Validation fail
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
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

            return redirect()->route('Home')->with('status','Password telah diubah, silahkan check Email anda');
        }
    }
}
