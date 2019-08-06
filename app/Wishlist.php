<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wishlist extends Model
{
    protected $table = 'tbl_wishlist';
    protected $fillable = ['customer_id','barang_id','status'];

    public static function filter($kat,$customer){
        return Wishlist::join('tbl_barang','tbl_barang.id','=','tbl_wishlist.barang_id')
        ->join('tbl_rating','tbl_rating.barang_id','=','tbl_barang.id')
        ->join('tbl_gallery','tbl_barang.id','=','tbl_gallery.barang_id')
        ->where('tbl_wishlist.customer_id',$customer)
        ->where('tbl_barang.kat_id',$kat)
        ->select(DB::raw('(SUM(value) / COUNT(value)) as rate,tbl_barang.id,tbl_barang.nama,tbl_barang.deskripsi,tbl_gallery.image'))
        ->get();
    }

    public static function checkWishlist($brg,$customer){
        $wishlist = Wishlist::where('barang_id',$brg)->where('customer_id',$customer)->count();
        return $wishlist;
    }

    public static function getWishlist($id){
        return Wishlist::join('tbl_barang','tbl_barang.id','=','tbl_wishlist.barang_id')
        ->join('tbl_gallery','tbl_barang.id','=','tbl_gallery.barang_id')
        ->where('tbl_wishlist.customer_id',$id)
        ->select(DB::raw('tbl_barang.id,tbl_barang.nama,tbl_barang.deskripsi,tbl_gallery.image,tbl_wishlist.id as wishlist_id'))
        ->distinct()
        ->groupBy('id')
        ->get();
    }

    public static function searchWishlist($id,$params){
        return Wishlist::join('tbl_barang','tbl_barang.id','=','tbl_wishlist.barang_id')
        ->join('tbl_gallery','tbl_barang.id','=','tbl_gallery.barang_id')
        ->where('tbl_wishlist.customer_id',$id)
        ->where('tbl_barang.nama','LIKE',$params.'%')
        ->select(DB::raw('tbl_barang.id,tbl_barang.nama,tbl_barang.deskripsi,tbl_gallery.image,tbl_wishlist.id as wishlist_id'))
        ->distinct()
        ->groupBy('id')
        ->get();
    }
}
