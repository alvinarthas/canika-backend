<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscribe;

class SubscribeController extends Controller
{
    public function subscribe(Request $request){
        $subs = new Subscribe(array(
            'email' => $request->email,
        ));

        $subs->save();

        return redirect()->back()->with("status","Terima Kasih!, info selanjutnya akan kami sampaikan via email :)");
    }

    public function all(){
        $subscribe = Subscribe::all();
        if(count($subscribe) > 0 ){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Subsribe Canika',
                'data' => $subscribe,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Subsribe Canika'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }
    
}
