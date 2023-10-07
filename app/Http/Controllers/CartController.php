<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PSpell\Dictionary;
use Cart;
session_start();

class CartController extends Controller
{
    public function save_cart(Request $request) {
        $productID = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id',$productID)->get();

        // Cart::add('293ad', 'Product 1', 1, 9.99);
        // Cart::destroy();
        $data['id'] = $product_info[0]->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info[0]->product_name;
        $data['price'] = $product_info[0]->product_price;
        $data['weight'] = $product_info[0]->product_price;
        $data['options']['image'] = $product_info[0]->product_image;
        Cart::add($data);
        return Redirect::to('/show-cart');

    }
    public function show_cart(){

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id','desc')->get();
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand', $brand_product);
    }
    public function delete_to_cart($rowId){
        Cart::update($rowId,0);
        return Redirect::to('/show-cart');
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }
}
