@extends('layout')
@section('content')
    <section id="cart_items">
        <div class="container">
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
                <form action="{{ url('/update-cart') }}" method="POST">
                    @csrf
                    <table class="table table-condensed">
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

                                                <input class="cart_quantity_" type="number" min="1"
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
                                    <th>
                                        Tổng tiền : <span>{{ number_format($total, 0, ',', '.') }}</span>
                                    </th>
                                    {{-- <li>Thuế <span></span></li>
                                    <li>Phí vận chuyển <span>Free</span></li>
                                    <li>Tiền sau giảm <span></span></li> --}}
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
                    </table>

                </form>
            </div>
        </div>
    </section> <!--/#cart_items-->

@endsection
