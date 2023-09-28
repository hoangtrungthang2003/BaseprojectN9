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
                    Chỉnh sửa thương hiệu sản phẩm
                </header>
                <div class="panel-body">
                    @foreach ($edit_brand_product as $key => $edit_value)
                       <div class="position-center">
                            <form role="form" action="{{URL::to('update-brand-product/'.$edit_value->brand_id)}}" method="post">
                                {{ csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên thương hiệu</label>
                                <input type="text" value="{{ $edit_value->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên thương hiệu">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                                <textarea name="brand_product_desc" style="resize: none" rows="5" class="form-control" id="exampleInputPassword1" >{{ $edit_value->brand_desc}}
                                </textarea>
                            </div>
                            <button type="submit" class="btn btn-info" name="add_brand_product">Cập nhật thương hiệu</button>
                            </form>
                        </div> 
                    @endforeach
                    

                </div>
            </section>

    </div>
@endsection
