<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Feeship;
Use App\Shipping;
Use App\Models\Order;
Use App\OrderDetails;
Use App\Customer;

class OrderController extends Controller
{
    public function view_order($order_code){
        $order_details = OrderDetails::where('order_code',$order_code)->get();
        $order = Order::where('order_code',$order_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();

        $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
        return view('admin.view_order')->with(compact('order_details','customer','shipping','order_details'));
    }
    public function manage_order(){
        $order = Order::orderby('created_at','DESC')->get();
        return view('admin.manage_order')->with(compact('order'));
    }
}
