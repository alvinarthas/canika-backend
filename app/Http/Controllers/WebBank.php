<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bank;

class WebBank extends Controller
{
    public function index(){
        $banks = Bank::all();

        return view('admin.bank.index',compact('banks'));
    }
}
