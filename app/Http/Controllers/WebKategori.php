<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Kategori;

class WebKategori extends Controller
{
    public function index(){
        $kategori = Kategori::all();

        return view('admin.kategori.index',compact('kategori'));
    }

    public function create(){
        $jenis = "create";
        return view('admin.kategori.form',compact('jenis'));
    }

    public function store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required|string',
        ]);
        // IF Validation fail
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        // Validation success
        }else{
            $kategori = new Kategori(array(
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ));
            
            try{
                $kategori->save();

                return redirect()->route('getKategori');
                // Response
            }catch(\Exception $e){
                return redirect()->back()->withErrors($e);
            }
        }
    }

    public function edit($id){
        $jenis = "edit";
        $kategori = Kategori::where('id',$id)->first();
        return view('admin.kategori.form',compact('jenis','kategori'));
    }

    public function update(Request $request, $id){
        $kategori = Kategori::where('id',$id)->first();
        try{
            $kategori->update(request()->all());

            return redirect()->route('getKategori');
        }catch(\Exception $e){
            return redirect()->back()->withErrors($e);
        }
    }

    public function destroy($id){
        $kategori = Kategori::where('id',$id)->first();
        $kategori->delete();
        return redirect()->route('getKategori');
    }
}
