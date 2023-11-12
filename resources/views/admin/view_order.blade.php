@extends('admin_layout')

@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin khách hàng
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>

                            <th>Tên khách hàng</th>
                            <th>Số điện thoại </th>
                            <th>Email </th>

                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->customer_phone }}</td>
                            <td>{{ $customer->customer_email }}</td>

                        </tr>

                    </tbody>
                </table>
            </div>


        </div>
    </div>
    <br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>

                            <th>Tên người vận chuyển</th>
                            <th>Địa chỉ </th>
                            <th>Số điện thoại </th>
                            <th>Email </th>
                            <th>Ghi chú </th>
                            <th>Hình thức thanh toán </th>

                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $shipping->shipping_name }}</td>
                            <td>{{ $shipping->shipping_address }}</td>
                            <td>{{ $shipping->shipping_phone }}</td>
                            <td>{{ $shipping->shipping_email }}</td>
                            <td>{{ $shipping->shipping_notes }}</td>
                            <td>
                                @if ($shipping->shipping_method == 0)
                                    Chuyển khoản
                                @else
                                    Tiền mặt
                                @endif
                            </td>


                        </tr>

                    </tbody>
                </table>
            </div>


        </div>
    </div>
    <br><br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê chi tiết đơn hàng
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá sản phẩm</th>
                            <th>Tổng tiền</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $total = 0;
                        @endphp
                        @foreach ($order_details as $key => $details)
                            @php
                                $i++;
                                $subtotal = $details->product_price * $details->product_sales_quantity;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td><i>{{ $i }}</i></label></td>
                                <td>{{ $details->product_name }}</td>
                                <td>{{ $details->product_sales_quantity }}</td>
                                <td>{{ number_format($details->product_price, 0, ',', '.') }} đ</td>
                                <td>{{ number_format($subtotal, 0, ',', '.') }} đ</td>

                            </tr>
                        @endforeach
                        <tr>
                            
                            <th colspan="3" >Thanh toán: {{ number_format($total, 0, ',', '.') }} đ</th>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
