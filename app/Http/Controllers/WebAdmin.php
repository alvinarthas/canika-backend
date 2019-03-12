<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Admins;
use App\Status;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;



class WebAdmin extends Controller
{
    public function index(){
        $admin = Admins::all();

        return view('admin.admin.index',compact('admin'));
    }

    public function create(){
        $jenis = "create";
        return view('admin.admin.form',compact('jenis'));
    }

    public function store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:8|confirmed',
            'nama' => 'required|string|max:50',
        ]);
        // IF Validation fail
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        // Validation success
        }else{
            $admins = new Admins(array(
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama' => $request->nama,
                'status' => 1,
            ));

            try{
                $admins->save();

                return redirect()->route('getAdmin');
                // Response
            }catch(\Exception $e){
                return redirect()->back()->withErrors($e);
            }
        }
    }

    public function edit($id){
        $jenis = "edit";
        $admin = Admins::where('id',$id)->first();
        $status = Status::where('jenis','admin')->get();
        return view('admin.admin.form',compact('jenis','admin','status'));
    }

    public function update(Request $request, $id){
        
        $admin = Admins::where('id',$id)->first();
        try{
            $admin->update(request()->all());

            return redirect()->route('getAdmin');
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e);
        }
    }

}