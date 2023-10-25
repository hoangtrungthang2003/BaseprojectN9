<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PSpell\Dictionary;
use Gloudemans\Shoppingcart\Facades\Cart;
session_start();

class CartController extends Controller
{
    public function gio_hang(Request $request){

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand_product')->orderby('brand_id','desc')->get();
        return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand', $brand_product);
    }
    public function add_cart_ajax(Request $request) {
        // $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);

        $cart_product_id = $request->input('cart_product_id');
        $cart_product_name = $request->input('cart_product_name');
        $cart_product_image = $request->input('cart_product_image');
        $cart_product_price = $request->input('cart_product_price');
        $cart_product_qty = $request->input('cart_product_qty');

    $cart = session('cart', []);

    if($cart==true){
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$cart_product_id){
                    $is_avaiable++;  
                }
            }
            if($is_avaiable == 0) {
                $cart[] = [
                    'session_id' => $session_id,
                    'product_id' => $cart_product_id,
                    'product_name' => $cart_product_name,
                    'product_image' => $cart_product_image,
                    'product_price' => $cart_product_price,
                    'product_qty' => $cart_product_qty
                ];
                session()->put('cart', $cart);
            }
        }else{
            $cart[] = [
                'session_id' => $session_id,
                'product_id' => $cart_product_id,
                'product_name' => $cart_product_name,
                'product_image' => $cart_product_image,
                'product_price' => $cart_product_price,
                'product_qty' => $cart_product_qty
            ];
            session()->put('cart', $cart);

        };
    session()->save();
    // session()->flush();
    
    }

    public function delete_product($session_id){
        $cart = Session::get('cart');
        if($cart==true) {
            foreach($cart as $key => $val) {
                if($val['session_id'] == $session_id){
                    unset($cart[$key]);
                }

            }
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Xoá sản phẩm thành công');
        }else {
            return redirect()->back()->with('message', 'Xoá sản phẩm thất bại');

        }
    }

    public function update_cart(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key => $qty){
               foreach($cart as $session => $val){
                if($val['session_id'] == $key){
                    $cart[$session]['product_qty'] = $qty;
                }
               }
            } 
            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Cập nhập số lượng thành công');
        }else {
            return redirect()->back()->with('message', 'Cập nhập số lượng thất bại');

        }
    }
    public function delete_all_product(){
        $cart = Session::get('cart');
        if($cart==true){
            Session::forget('cart');
            return redirect()->back()->with('message','Xoá hết giỏ hàng thành công');
        }
    }
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
        // Cart::destroy();

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
