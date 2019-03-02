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
        
    }

    public function edit($id){
        
    }

    public function update(Request $request, $id){

    }

    public function delete($id){

    }
}
