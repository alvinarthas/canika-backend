<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rekening;
use App\Bank;

class WebRekening extends Controller
{
    public function index(){
        $rekening = Rekening::all();

        return view('admin.rekening.index',compact('rekening'));
    }

    public function create(){
        $jenis = "create";
        $banks = Bank::all();
        return view('admin.rekening.form',compact('jenis','banks'));
    }

    public function store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'bank_id' => 'required',
            'nama_pemilik' => 'required|string',
            'norek' => 'required',
        ]);
        // IF Validation fail
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        // Validation success
        }else{
            $rekening = new Rekening(array(
                'bank_id' => $request->bank_id,
                'nama' => $request->nama,
                'nama_pemilik' => $request->nama_pemilik,
                'norek' => $request->norek,
            ));
            
            try{
                $rekening->save();

                return redirect()->route('getRekening');
                // Response
            }catch(\Exception $e){
                return redirect()->back()->withErrors($e);
            }
        }
    }

    public function edit($id){
        $jenis = "edit";
        $banks = Bank::all();
        $rekening = Rekening::where('id',$id)->first();
        return view('admin.rekening.form',compact('jenis','rekening','banks'));
    }

    public function update(Request $request, $id){
        $rekening = Rekening::where('id',$id)->first();
        try{
            $rekening->update(request()->all());

            return redirect()->route('getRekening');
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e);
        }
    }

    public function destroy($id){
        $rekening = Rekening::where('id',$id)->first();
        $rekening->delete();
        return redirect()->route('getRekening');
    }
}
