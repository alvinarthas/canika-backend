<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Gallery;
use App\Wishlist;

class Barang extends Model
{
    protected $table = 'tbl_barang';
    protected $fillable = ['nama','kat_id','deskripsi','jenis','qty','harga1','harga2','vendor_id','status','kategori_value'];

    public function vendor(){
        return $this->belongsTo('App\Vendor');
    }

    public function gallery(){
        return $this->hasMany('App\Gallery');
    }

    public function kategori(){
        return $this->hasOne('App\Kategori','id','kat_id');
    }

    public static function show($id,$customer=NULL){
        $barang = Barang::where('id',$id)->first();
        if($barang){
            $gallery = array();
            foreach($barang->gallery()->get() as $galer){
                array_push($gallery,$galer->image);
            }
            $brg = collect($barang);

            if($customer){
                $checkwishlist = Wishlist::checkWishlist($id,$customer);
                if($checkwishlist > 0){
                    $wishlist_id = Wishlist::where('barang_id',$id)->where('customer_id',$customer)->first()->id;
                    $brg->put('wishlist',1);
                    $brg->put('wishlist_id',$wishlist_id);
                }else{
                    $brg->put('wishlist',0);
                }
            }else{
                $brg->put('wishlist',999);
            }

            $kategori = $barang->kategori()->first();

            $brg->put('field',$kategori->field);
            $brg->put('prov',$barang->vendor()->first()->prov);
            $brg->put('kota',$barang->vendor()->first()->kota);

            return $brg->put('gallery',$gallery);
        }
    }

    public static function show_all(){
        $barangall = Barang::all();
        $data = collect();
        foreach($barangall as $barang){
            $gallery = array();
            foreach($barang->gallery()->get() as $galer){
                array_push($gallery,$galer->image);
            }
            $brg = collect($barang);

            $brg->put('gallery',$gallery);
            $data->push($brg);
        }
        return $data;
    }

    public static function show_category($jenis,$id){
        $barangall = Barang::where('kat_id',$id)->where('jenis',$jenis)->paginate(10);
        $data = collect();
        $i=1;
        foreach($barangall as $barang){
            $gallery = array();
            $gallery = $barang->gallery()->first()->image;
            $brg = collect($barang);

            $brg->put('image',$gallery);
            $data->push($brg);
        }
        return $data;
    }

    public static function search($param){
        $barangall = Barang::where('nama','like',$param.'%')->paginate(5);
        $data = collect();
        $i=1;
        foreach($barangall as $barang){
            $gallery = array();
            $gallery = $barang->gallery()->first()->image;
            $brg = collect($barang);

            $brg->put('image',$gallery);
            $data->push($brg);
        }
        return $data;
    }
}
