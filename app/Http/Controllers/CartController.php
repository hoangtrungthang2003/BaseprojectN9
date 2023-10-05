<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PSpell\Dictionary;
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request) {
        $productID = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id',$productID)->get();
        
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id','desc')->get();

        

        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand', $brand_product);
    }
}
