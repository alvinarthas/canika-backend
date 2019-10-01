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
        $rating = Barang::join('tbl_rating','tbl_rating.barang_id','=','tbl_barang.id')->join('tbl_vendor as a','a.id','=','tbl_barang.vendor_id')->join('tbl_gallery','tbl_barang.id','=','tbl_gallery.barang_id')->where('a.status',1)->groupBy('tbl_rating.barang_id')->orderBy(DB::raw('(SUM(value) / COUNT(value))'),'desc')->select(DB::raw('(SUM(value) / COUNT(value)) as rate,a.id,a.nama,a.avatar,a.deskripsi'))->distinct()->get();
        return $rating;
    }

    public static function getRating($id){
        $rating = Rating::join('tbl_barang','tbl_rating.barang_id','=','tbl_barang.id')->where('tbl_barang.id',$id)->select(DB::raw('(SUM(value) / COUNT(value)) as rate'))->groupBy('tbl_rating.barang_id')->orderBy('rate','desc')->get();
        return $rating;
    }

    public static function filterRating($harga1,$harga2,$rating,$kat,$tag){
        $rate = Barang::join('tbl_vendor as a','a.id','=','tbl_barang.vendor_id')
        ->join('brg_tag','brg_tag.barang_id','=','tbl_barang.id');

        if($rating <> ''){
            $rate->join('tbl_rating','tbl_rating.barang_id','=','tbl_barang.id');
        }
        $rate->where('a.status',1);
        if(is_array($tag)){
            $rate->whereIn('brg_tag.tag_id',$tag)->get();
        }
        if($kat <> ''){
            $rate->where('tbl_barang.kat_id',$kat);
        }
        
        if($harga1 <> '' && $harga2 <> ''){
            $rate->whereBetween('tbl_barang.harga1',[$harga1,$harga2]);
        }
        $rate->select(DB::raw('a.id,a.nama,a.avatar,a.deskripsi'));
        if($rating <> ''){
            $rate->groupBy('tbl_rating.barang_id');
            $rate->havingRaw(DB::raw('(SUM(tbl_rating.value) / COUNT(tbl_rating.value)) BETWEEN '.$rating.' AND '.($rating+0.9).''));
            $rate->orderBy(DB::raw('(SUM(value) / COUNT(value))'),'desc');
        }

        return $rate->distinct()->get();
    }

    public static function filterRatingSearch($harga1,$harga2,$rating,$kat,$param,$tag){
        $rate = Barang::join('tbl_vendor as a','a.id','=','tbl_barang.vendor_id')
        ->join('tbl_gallery','tbl_barang.id','=','tbl_gallery.barang_id')
        ->join('brg_tag','brg_tag.barang_id','=','tbl_barang.id')->where('a.status',1);
        if($rating <> ''){
            $rate->join('tbl_rating','tbl_rating.barang_id','=','tbl_barang.id');
        }
        if($kat <> ''){
            $rate->where('tbl_barang.kat_id',$kat);
        }
        if(is_array($tag)){
            if($tag[0] <> null){
                $rate->whereIn('brg_tag.tag_id',$tag);
            }
        }
        if($harga1 <> '' && $harga2 <> ''){
            $rate->whereBetween('tbl_barang.harga1',[$harga1,$harga2]);
        }
        if($param <> ''){
            $rate->where('tbl_barang.nama','like',$param.'%')->orWhere('a.nama','like','%'.$param.'%')->orWhere('a.username','like','%'.$param.'%');
        }
        
        $rate->select(DB::raw('a.id,a.nama,a.avatar,a.deskripsi'));
        if($rating <> ''){
            $rate->groupBy('tbl_rating.barang_id');
            $rate->havingRaw(DB::raw('(SUM(tbl_rating.value) / COUNT(tbl_rating.value)) BETWEEN '.$rating.' AND '.($rating+0.9).''));
            $rate->orderBy(DB::raw('(SUM(value) / COUNT(value))'),'desc');
        }
        return $rate->distinct()->get();
    }
}
