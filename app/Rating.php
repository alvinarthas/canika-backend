<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Barang;

class Rating extends Model
{
    protected $table = 'tbl_rating';
    protected $fillable = ['customer_id','barang_id','value'];

    public static function getPopularBarang(){
        $rating = Rating::join('tbl_barang','tbl_barang.id','=','tbl_rating.barang_id')->join('tbl_gallery','tbl_barang.id','=','tbl_gallery.barang_id')->groupBy('tbl_rating.barang_id')->orderBy('rate','desc')->select(DB::raw('(SUM(value) / COUNT(value)) as rate,nama,tbl_gallery.image,tbl_barang.id'))->get();
        return $rating;
    }

    public static function getPopularVendor(){
        $rating = Barang::join('tbl_rating','tbl_rating.barang_id','=','tbl_barang.id')->join('tbl_vendor as a','a.id','=','tbl_barang.vendor_id')->join('tbl_gallery','tbl_barang.id','=','tbl_gallery.barang_id')->groupBy('tbl_rating.barang_id')->orderBy(DB::raw('(SUM(value) / COUNT(value))'),'desc')->select('a.id','a.nama','a.avatar','a.deskripsi')->get();
        return $rating;
    }

    public static function getRating($id){
        $rating = Rating::join('tbl_barang','tbl_rating.barang_id','=','tbl_barang.id')->where('tbl_barang.id',$id)->select(DB::raw('(SUM(value) / COUNT(value)) as rate'))->groupBy('tbl_rating.barang_id')->orderBy('rate','desc')->get();
        return $rating;
    }

    public static function filterRating($harga1,$harga2,$rating,$kat){
        $rate = Barang::join('tbl_rating','tbl_rating.barang_id','=','tbl_barang.id')->join('tbl_vendor as a','a.id','=','tbl_barang.vendor_id')->join('tbl_gallery','tbl_barang.id','=','tbl_gallery.barang_id')->where('tbl_barang.kat_id',$kat)->whereBetween('tbl_barang.harga1',[$harga1,$harga2])->select(DB::raw('a.id,a.nama,a.avatar,a.deskripsi'))->groupBy('tbl_rating.barang_id')->havingRaw(DB::raw('(SUM(tbl_rating.value) / COUNT(tbl_rating.value)) BETWEEN '.$rating.' AND '.($rating+0.9).''))->orderBy(DB::raw('(SUM(value) / COUNT(value))'),'desc')->get();

        return $rate;
    }

    public static function filterRatingSearch($harga1,$harga2,$rating,$kat,$param){
        $rate = Barang::join('tbl_rating','tbl_rating.barang_id','=','tbl_barang.id')->join('tbl_vendor as a','a.id','=','tbl_barang.vendor_id')->join('tbl_gallery','tbl_barang.id','=','tbl_gallery.barang_id')->where('tbl_barang.kat_id',$kat)->whereBetween('tbl_barang.harga1',[$harga1,$harga2])->where('tbl_barang.nama','like',$param.'%')->orWhere('a.nama','like',$param.'%')->select(DB::raw('a.id,a.nama,a.avatar,a.deskripsi'))->groupBy('tbl_rating.barang_id')->havingRaw(DB::raw('(SUM(tbl_rating.value) / COUNT(tbl_rating.value)) BETWEEN '.$rating.' AND '.($rating+0.9).''))->orderBy(DB::raw('(SUM(value) / COUNT(value))'),'desc')->get();

        return $rate;
    }
}
