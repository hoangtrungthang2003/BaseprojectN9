@extends('layout')
@section('content')
    <section id="cart_items">
        <div class="container" style="width:100%">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Giỏ hàng của bạn</li>
                </ol>
            </div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <form action="{{ url('/update-cart') }}" method="POST">
                        @csrf
                        <thead>
                            <tr class="cart_menu">
                                <td class="image">Hình ảnh</td>
                                <td class="description">Tên sản phẩm</td>
                                <td class="price">Giá sản phẩm</td>
                                <td class="quantity">Số lượng</td>
                                <td class="total">Thành tiền</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (Session::get('cart') == true)
                                @php
                                    $total = 0;
                                @endphp
                                @foreach (Session::get('cart') as $item => $cart)
                                    @php
                                        $subtotal = $cart['product_qty'] * $cart['product_price'];
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td class="cart_product">
                                            <img src="{{ asset('public/uploads/product/' . $cart['product_image']) }}"
                                                width="90" alt="{{ $cart['product_name'] }}">
                                        </td>
                                        <td class="cart_description">
                                            <h4><a href="">{{ $cart['product_name'] }}</a></h4>
                                            <p></p>
                                        </td>
                                        <td class="cart_price">
                                            <p>{{ number_format($cart['product_price'], 0, ',', '.') }} VNĐ</p>
                                        </td>
                                        <td class="cart_quantity">
                                            <div class="cart_quantity_button">

                                                <input class="cart_quantity_" type="number" min="1" style="width: 80px"
                                                    name="cart_qty[{{ $cart['session_id'] }}]"
                                                    value="{{ $cart['product_qty'] }}">
                                                <input type="hidden" value="" name="rowId_cart" class="form-control">

                                            </div>
                                        </td>
                                        <td class="cart_total">
                                            <p class="cart_total_price">
                                                {{ number_format($subtotal, 0, ',', '.') }}
                                            </p>
                                        </td>
                                        <td class="cart_delete">
                                            <a class="cart_quantity_delete"
                                                href="{{ url('del-product/' . $cart['session_id']) }}"><i
                                                    class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        <input type="submit" value="Cập nhật giỏ hàng" name="update_qty"
                                            class="check_out btn btn-default btn-sm">
                                    </td>
                                    <td>
                                        <a class="btn btn-default check_out" href="{{ url('/del-all-product') }}">Xoá tất
                                            cả</a>
                                    </td>
                                    <td>
                                        @if(Session::get('coupon'))
                                        <a class="btn btn-default check_out" href="{{ url('/unset-coupon') }}">Xoá mã khuyến mãi</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(Session::get('customer'))
                                        <a class="btn btn-default check_out" href="{{ url('/checkout') }}">Đặt hàng</a>
                                        @else
                                        <a class="btn btn-default check_out" href="{{ url('/login-checkout') }}">Đặt hàng</a>
                                        @endif
                                    </td>

                                    <td colspan="2">
                                        <li>Tổng tiền : <span>{{ number_format($total, 0, ',', '.') }}</span></li>
                                        @if (Session::get('coupon'))
                                        <li>
                                                @foreach (Session::get('coupon') as $key => $cou)
                                                    @if ($cou['coupon_condition'] == 1)
                                                        Mã giảm: {{$cou['coupon_number']}} %
                                                        <p>
                                                            @php
                                                                $total_coupon = ($total*$cou['coupon_number'])/100;
                                                                echo '<p><li>Tổng giảm : '.number_format($total_coupon, 0, ',','.').'đ</li></p>';
                                                            @endphp
                                                        <p><li>Tổng đã giảm : {{number_format($total - $total_coupon,0,',','.')}} đ</li></p>
                                                        </p>
                                                    @else
                                                        Mã giảm: {{number_format($cou['coupon_number'],0,',','.')}} đ
                                                        <p>
                                                            @php
                                                                $total_coupon = $total - $cou['coupon_number'];
                                                            @endphp
                                                        </p>
                                                        <p><li>Tổng đã giảm : {{number_format($total_coupon,0,',','.')}} đ</li></p>
                                                    @endif
                                                @endforeach
                                            </li>
                                            @endif
                                        {{-- <li>Phí vận chuyển <span>Free</span></li>
                                        <li>Tiền sau giảm <span></span></li> --}}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5">
                                        <div class="alert alert-danger">
                                            Giỏ hàng rỗng! Làm ơn hãy thêm sản phẩm vào giỏ hàng!
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </form>
                    @if (Session::get('cart'))
                    <tr>
                        <td>

                            <form action="{{ url('/check-coupon') }}" method="POST">
                                @csrf
                                <input type="text" class="form-control" name="coupon"
                                    placeholder="Nhập mã giảm giá"><br>
                                <input type="submit" class="btn btn-default check_coupon" name="check_coupon"
                                    value="Tính mã giảm giá">
                            </form>
                        </td>
                    </tr>
                    @endif
                </table>

            </div>
        </div>
    </section> <!--/#cart_items-->

@endsection
