<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rekening;

class WebRekening extends Controller
{
    public function index(){
        $rekening = Rekening::all();

        return view('admin.rekening.index',compact('rekening'));
    }
}
