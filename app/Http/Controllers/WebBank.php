<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Bank;

class WebBank extends Controller
{
    public function index(){
        $banks = Bank::all();
        return view('admin.bank.index',compact('banks'));
    }

    public function create(){
        $jenis = "create";
        return view('admin.bank.form',compact('jenis'));
    }

    public function store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
        ]);
        // IF Validation fail
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        // Validation success
        }else{
            $bank = new Bank(array(
                'nama' => $request->nama,
                'image' => $request->image,
            ));
            
            try{
                $bank->save();

                return redirect()->route('getBank');
                // Response
            }catch(\Exception $e){
                return redirect()->back()->withErrors($e);
            }
        }
    }

    public function edit($id){
        $jenis = "edit";
        $bank = Bank::where('id',$id)->first();
        return view('admin.bank.form',compact('jenis','bank'));
    }

    public function update(Request $request, $id){
        $bank = Bank::where('id',$id)->first();
        try{
            $bank->update(request()->all());

            return redirect()->route('getBank');
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e);
        }
    }

    public function destroy($id){
        $bank = Bank::where('id',$id)->first();
        $bank->delete();
        return redirect()->route('getBank');
    }
}
