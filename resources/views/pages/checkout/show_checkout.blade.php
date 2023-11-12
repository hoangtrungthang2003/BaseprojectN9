@extends('layout')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Thanh toán giỏ hàng</li>
                </ol>
        </div>

        <div class="register-req">
            <p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
        </div><!--/register-req-->

        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-12 clearfix">
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
                                        <td class="total">Tổng tiền</td>
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
                                                <td class="cart_description" style="max-width: 200px;">
                                                    <h4><a href="">{{ $cart['product_name'] }}</a></h4>
                                                    <p></p>
                                                </td>
                                                <td class="cart_price">
                                                    <p>{{ number_format($cart['product_price'], 0, ',', '.') }} VNĐ</p>
                                                </td>
                                                <td class="cart_quantity">
                                                    <div class="cart_quantity_button">

                                                        <input class="cart_quantity_" type="number" min="1"
                                                            name="cart_qty[{{ $cart['session_id'] }}]"
                                                            value="{{ $cart['product_qty'] }}" style="width: 80px">
                                                        <input type="hidden" value="" name="rowId_cart"
                                                            class="form-control">

                                                    </div>
                                                </td>
                                                <td class="cart_total">
                                                    <p class="cart_total_price">
                                                        {{ number_format($subtotal, 0, ',', '.') }} VND
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
                                                <a class="btn btn-default check_out"
                                                    href="{{ url('/del-all-product') }}">Xoá tất
                                                    cả</a>
                                            </td>
                                            <td>
                                                <a class="btn btn-default check_out" href="{{ url('/unset-coupon') }}">Xoá
                                                    mã khuyến mãi</a>
                                            </td>

                                            <td colspan="2">
                                                <li>Tổng tiền : <span>{{ number_format($total, 0, ',', '.') }}</span></li>
                                                @if (Session::get('coupon'))
                                                    <li>
                                                        @foreach (Session::get('coupon') as $key => $cou)
                                                            @if ($cou['coupon_condition'] == 1)
                                                                Mã giảm: {{ $cou['coupon_number'] }} %
                                                                <p>
                                                                    @php
                                                                        $total_coupon = ($total * $cou['coupon_number']) / 100;
                                                                        echo '<p><li>Tổng giảm : ' . number_format($total_coupon, 0, ',', '.') . 'đ</li></p>';
                                                                    @endphp
                                                                <p>
                                                    <li>Tổng đã giảm :
                                                        {{ number_format($total - $total_coupon, 0, ',', '.') }} đ</li>
                                                    </p>
                                                    </p>
                                                @else
                                                    Mã giảm: {{ number_format($cou['coupon_number'], 0, ',', '.') }} đ
                                                    <p>
                                                        @php
                                                            $total_coupon = $total - $cou['coupon_number'];
                                                        @endphp
                                                    </p>
                                                    <p>
                                                        <li>Tổng đã giảm : {{ number_format($total_coupon, 0, ',', '.') }}
                                                            đ
                                                        </li>
                                                    </p>
                                                @endif
                                    @endforeach
                                    </li>
                                    @endif

                                    @if (Session::get('fee'))
                                        <li>
                                            <a class="cart_quantity_delete" href="{{ url('/del-fee') }}"><i
                                                    class="fa fa-times"></i></a>
                                            Phí vận chuyển <span>{{ number_format(Session::get('fee'), 0, ',', '.') }}
                                                đ</span>
                                        </li>
                                    @endif
                                    <li><b>
                                            Thành tiền:
                                            @php
                                                if (Session::get('fee') && !Session::get('coupon')) {
                                                    $total_after = $total + Session::get('fee');
                                                    echo number_format($total_after, 0, ',', '.') . 'đ';
                                                } elseif (!Session::get('fee') && Session::get('coupon')) {
                                                    $total_after = $total_coupon;
                                                    echo number_format($total_after, 0, ',', '.') . 'đ';
                                                } elseif (Session::get('fee') && Session::get('coupon')) {
                                                    $total_after = $total_coupon + Session::get('fee');

                                                    echo number_format($total_after, 0, ',', '.') . 'đ';
                                                } elseif (!Session::get('fee') && !Session::get('coupon')) {
                                                    $total_after = $total;
                                                    echo number_format($total_after, 0, ',', '.') . 'đ';
                                                }
                                            @endphp
                                        </b>
                                    </li>
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
                <div class="col-sm-12 clearfix">
                    <div class="bill-to">
                        <p>Điền thông tin gửi hàng</p>
                        <div class="form-one" style="display: flex; width: 100%;">
                            <form role="form" action="{{ URL::to('/save-brand-product') }}"
                                method="post"style="width: 50%; margin-right: 20px">
                                @csrf

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn thành phố</label>
                                    <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                        <option value="">--- Chọn tỉnh/thành phố ---</option>
                                        @foreach ($city as $key => $ci)
                                            <option value="{{ $ci->matp }}">{{ $ci->name_city }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn quận huyện</label>
                                    <select name="province" id="province"
                                        class="form-control input-sm m-bot15 choose province">
                                        <option value="">--- Chọn quận huyện ---</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn xã phường</label>
                                    <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                        <option value="">--- Chọn xã phường ---</option>
                                    </select>
                                </div>
                                <input type="button" value="Tính phí vận chuyển" name="calculate_order" style="width: 70%; margin-left: 15%"
                                    class="btn btn-primary btn-sm calculate_delivery">
                            </form>
                            <form method="POST" style="width: 50%; margin-right: 20px">
                                @csrf
                                <input type="text" name="shipping_email" class="shipping_email" placeholder="Email">
                                <input type="text" name="shipping_name" class="shipping_name"
                                    placeholder="Họ và tên">
                                <input type="text" name="shipping_address" class="shipping_address"
                                    placeholder="Địa chỉ">
                                <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Phone">
                                <textarea name="shipping_notes" class="shipping_notes" placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>
                                @if (Session::get('fee'))
                                    <input type="hidden" name="order_fee" class="order_fee"
                                        value="{{ Session::get('fee') }}">
                                @else
                                    <input type="hidden" name="order_fee" class="order_fee" value="30000">
                                @endif

                                @if (Session::get('coupon'))
                                    @foreach (Session::get('coupon') as $key => $cou)
                                        <input type="hidden" name="order_coupon" class="order_coupon"
                                            value="{{ $cou['coupon_code'] }}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="order_coupon" class="order_coupon" value="no">
                                @endif

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                                    <select name="payment_select" class="form-control input-sm m-bot15 payment_select">
                                        <option value="0">Qua chuyển khoản</option>
                                        <option value="1">Tiền mặt</option>
                                    </select>
                                </div>
                                <input type="button" value="Xác nhận đơn hàng" name="send_order" style="font-size: 16px"
                                    class="btn btn-primary btn-sm send_order">
                            </form>


                        </div>
                    </div>
                </div>

            </div>
        </div>

        </div>
    </section> <!--/#cart_items-->

@endsection
