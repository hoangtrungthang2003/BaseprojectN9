<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PSpell\Dictionary;
use App\Models\Slider;
session_start();

class HomeController extends Controller
{
    public function show(){

        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();


        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id','desc')->get();
        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        // ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
        // ->orderBy('tbl_product.product_id', 'desc')
        // ->get();
        $all_product = DB::table('tbl_product')->where('product_status','0')->orderBy('product_id','desc')->limit(4)->get();
        return view('pages.home')->with('category',$cate_product)->with('brand', $brand_product)->with('all_product',$all_product)->with('slider',$slider);
    }
    public function search(Request $request){

        $keyword = $request->keyword_submit;
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id','desc')->get();
        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
        // ->join('tbl_brand_product', 'tbl_brand_product.brand_id', '=', 'tbl_product.brand_id')
        // ->orderBy('tbl_product.product_id', 'desc')
        // ->get();
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keyword.'%')->get();
        return view('pages.sanpham.search')->with('category',$cate_product)->with('brand', $brand_product)->with('search_product',$search_product);
    }
}
