<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

session_start();

class CouponController extends Controller

{
    public function unset_coupon(){
        $coupon = Session::get('coupon');
        if($coupon == true) {
            Session::forget('coupon');
            return redirect()->back()->with('message', 'Xoá mã khuyến mãi thành công');
        }
    }

    public function delete_coupon($coupon_id) {
        Coupon::where('coupon_id', $coupon_id)->delete();
        Session::put('message', 'Xoá mã giảm giá thành công');
        return Redirect::to('list-coupon');
    }
    public function list_coupon(){
        $coupon = Coupon::orderBy('coupon_id', 'DESC')->get();
        return view('admin.coupon.list_coupon')->with(compact('coupon'));
    }

    public function insert_coupon() {
        return view('admin.coupon.insert_coupon');
    } 
    public function insert_coupon_code(Request $request) {
        $data = $request->all();
        $coupon = new Coupon;

        $coupon->coupon_name = strval($data['coupon_name']);
        $coupon->coupon_code = strval($data['coupon_code']);
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_number = $data['coupon_number'];
        $coupon->save();

        Session::put('message', 'Thêm mã giảm giá thành công');
        return Redirect::to('insert-coupon');
    }
}
