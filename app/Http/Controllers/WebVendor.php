<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;
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
        
    }

    public function edit($id){
        
    }

    public function update(Request $request, $id){

    }

    public function delete($id){

    }
}
