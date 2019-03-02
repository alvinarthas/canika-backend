<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;

class WebKategori extends Controller
{
    public function index(){
        $kategori = Kategori::all();

        return view('admin.kategori.index',compact('kategori'));
    }
}
