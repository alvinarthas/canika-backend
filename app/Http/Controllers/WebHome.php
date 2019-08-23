<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Admin;

class WebHome extends Controller
{
    public function index(Request $request){
        if ($request->session()->has('isLoggedIn')) {
            return view('admin.home.home');
        }else{
            return view('admin.home.login');
        }
        
    }

    public function home(){
        return view('mail.verifyEmail');
    }

    public function login(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);
        
        // IF Validation fail
        if ($validator->fails()) {

            return redirect()->back();

        }else{
            $user = Admin::where('username',$request->username)->first();

            // FOUND
            if($user && Hash::check($request->password, $user->password)){
                $request->session()->put('username', $request->username);
                $request->session()->put('isLoggedIn', 'Ya');

                return redirect()->route('getCustomer');
            
            // NOT FOUND 
            }else{
                return redirect()->back();
            }
        }
        
    }

    public function logout(Request $request){
        $request->session()->flush();

        return redirect()->route('getHome');
    }
}
