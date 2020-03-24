<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Validator;

// Model
use App\Barang;
use App\Jenis;
use App\Gallery;
use App\Rating;
use App\Wishlist;
use App\Tag;
use App\BarangTag;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $statusCode = 200;
        $data = array(
            'code' => '200',
            'status' => 'success',
            'message' => 'Daftar Barang',
            'data' => Barang::show_all()
        );
        return response()->json($data,$statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // Validate
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'kat_id' => 'required|integer',
            'harga1' => 'required|integer',
            'harga2' => 'required|integer',
            'vendor_id' => 'required|integer',
            'status' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors()->all(),
            );
        // Validation success
        }else{
            $barang = new Barang(array(
                'nama' => $request->nama,
                'kat_id' => $request->kat_id,
                'deskripsi' => $request->deskripsi,
                'jenis' => $request->jenis,
                'qty' => $request->qty,
                'harga1' => $request->harga1,
                'harga2' => $request->harga2,
                'vendor_id' => $request->vendor_id,
                'status' => $request->status,
                'kategori_value' => $request->kategori_value,
            ));
            try{
                $barang->save();
                try{
                    if($request->gallery){
                        foreach($request->gallery as $image){
                            $image = new Gallery(array(
                                'barang_id'=> $barang->id,
                                'image' => $image
                            ));

                            $image->save();
                        }
                    }
                    if($request->tag){
                        foreach($request->tag as $tag){
                            $brg_tag = new BarangTag(array(
                                'barang_id'=> $barang->id,
                                'tag_id' => $tag
                            ));
    
                            $brg_tag->save();
                        }
                    }
                    
                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Barang berhasil dibuat',
                        'data' => $barang->id,
                    );
                }catch(\Exception $e){
                    $statusCode = 500;
                    $data = array(
                        'code' => '500',
                        'status' => 'error',
                        'message' => $e,
                    );
                }
            }catch(\Exception $e){
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => $e,
                );
            }
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,Request $request){
        $customer_id = $request->customer_id;
        $barang = Barang::show($id,$customer_id);
        if($barang){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Kategori',
                'data' => $barang,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Barang/Jasa tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        // Validate
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Silahkan cek kelengkapan form anda',
                'data' => $validator->errors()->all(),
            );
        }else{
            $barang = Barang::where('id',$id)->first();
            if($barang){

                try{
                    $barang->update(request()->all());
                    if($request->gallery){
                        foreach($request->gallery as $image){
                            $image = new Gallery(array(
                                'barang_id'=> $id,
                                'image' => $image
                            ));

                            $image->save();
                        }
                    }

                    $deltag = BarangTag::where('barang_id',$id)->delete();
                    if($request->tag){
                        foreach($request->tag as $tag){
                            $brg_tag = new BarangTag(array(
                                'barang_id'=> $barang->id,
                                'tag_id' => $tag
                            ));
    
                            $brg_tag->save();
                        }
                    }
                    
                    // Response
                    $statusCode = 200;
                    $data = array(
                        'code' => '200',
                        'status' => 'success',
                        'message' => 'Barang berhasil diubah'
                    );
                }catch(\Exception $e){
                    $statusCode = 500;
                    $data = array(
                        'code' => '500',
                        'status' => 'error',
                        'message' => "$e",
                    );
                }
            }else{
                $statusCode = 500;
                $data = array(
                    'code' => '500',
                    'status' => 'error',
                    'message' => 'Data Barang/Jasa tidak ditemukan'
                );
            }
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $barang = Barang::where('id',$id);
        if($barang){
            $barang->delete();
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Barang/Jasa Berhasil dihapus',
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Barang/Jasa tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function jenis(){
        $statusCode = 200;
        $data = array(
            'code' => '200',
            'status' => 'success',
            'message' => 'Daftar Jenis',
            'data' => Jenis::all()
        );
        return response()->json($data,$statusCode);
    }

    public function barang_category($jenis,$id){
        $barang = Barang::show_category($jenis,$id);
        if($barang){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Daftar Barang/Jasa ditemukan',
                'data' => $barang
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'gagal',
                'message' => 'Daftar Barang/Jasa tidak ditemukan'
            );
        }

        return response()->json($data,$statusCode);
    }

    public function search(Request $request){
        $param = $request->param;

        $result = Barang::search($param);

        if($result){
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Daftar Barang/Jasa ditemukan',
                'data' => $result
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'gagal',
                'message' => 'Daftar Barang/Jasa tidak ditemukan'
            );
        }

        return response()->json($data,$statusCode);
    }

    public function filter(){
    }

    public function popular($customer){
        $barang = Rating::getPopularBarang();
        if($barang){
            $barang_new = collect();
            foreach($barang as $brg){
                $brgs = collect($brg);
                if($customer <> 0){
                    $checkwishlist = Wishlist::checkWishlist($brg->id,$customer);
                    if($checkwishlist > 0){
                        $wishlist_id = Wishlist::where('barang_id',$brg->id)->where('customer_id',$customer)->first()->id;
                        $brgs->put('wishlist',1);
                        $brgs->put('wishlist_id',$wishlist_id);
                    }else{
                        $brgs->put('wishlist',0);
                    }
                }else{
                    $brgs->put('wishlist',999);
                }
                $barang_new->push($brgs);
            }
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Barang/Jasa Popular',
                'data' => $barang_new,
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Barang/Jasa tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function gallery_delete(Request $request){
        $image = $request->image;

        $gallery = Gallery::where('image',$image);
        if($gallery){
            $gallery->delete();
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Gambar Berhasil dihapus',
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Gambar tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function tag_delete(Request $request){
        $tag = $request->tag;
        $barang = $request->barang;

        $brg_tag = BarangTag::where('tag_id',$tag)->where('barang_id',$barang)->first();
        if($brg_tag){
            $brg_tag->delete();
            $statusCode = 200;
            $data = array(
                'code' => '200',
                'status' => 'success',
                'message' => 'Data Gambar Berhasil dihapus',
            );
        }else{
            $statusCode = 500;
            $data = array(
                'code' => '500',
                'status' => 'error',
                'message' => 'Data Gambar tidak ditemukan'
            );
        }
        // Send Response
        return response()->json($data,$statusCode);
    }

    public function tag_all(){
        $statusCode = 200;
        $data = array(
            'code' => '200',
            'status' => 'success',
            'message' => 'Daftar Tag',
            'data' => Tag::all()
        );
        return response()->json($data,$statusCode);
    }
}
