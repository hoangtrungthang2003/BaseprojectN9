@extends('admin_layout')

@section('admin_content')
{{-- < class="row"> --}}
    <div class="col-lg-12">
            <section class="panel">
                <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-alert">'.$message.'</span>';
                        Session::put('message', null);
                    }
                    ?>
                <header class="panel-heading">
                    Thêm mã giảm giá
                </header>
                <div class="panel-body">
                    
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/insert-coupon-code')}}" method="post">
                            @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên mã giảm giá</label>
                            <input type="text" name="coupon_name" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mã giảm giá</label>
                            <input type="text" name="coupon_code" class="form-control" id="exampleInputEmail1">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Số lượng mã</label>
                            <input type="number" name="coupon_time" class="form-control" id="exampleInputEmail1">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tính năng mã</label>
                            <select name="coupon_condition" class="form-control input-sm m-bot15">
                                <option value="0">----Chọn----</option>
                                <option value="1">Giảm theo phần trăm</option>
                                <option value="2">Giảm theo số tiền</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nhập số % hoặc tiền giảm</label>
                            <input type="number" name="coupon_number" class="form-control" id="exampleInputEmail1">

                        </div>
    

                        <button type="submit" class="btn btn-info" name="add_coupon">Thêm mã</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
@endsection
