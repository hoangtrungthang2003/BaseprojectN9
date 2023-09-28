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
                    Chỉnh sửa danh mục sản phẩm
                </header>
                <div class="panel-body">
                    @foreach ($edit_category_product as $key => $edit_value)
                       <div class="position-center">
                            <form role="form" action="{{URL::to('update-category-product/'.$edit_value->category_id)}}" method="post">
                                {{ csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục</label>
                                <input type="text" value="{{ $edit_value->category_name}}" name="category_product_name" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả danh mục</label>
                                <textarea name="category_product_desc" style="resize: none" rows="5" class="form-control" id="exampleInputPassword1" >{{ $edit_value->category_desc}}
                                </textarea>
                            </div>
                            <button type="submit" class="btn btn-info" name="add_category_product">Cập nhật danh mục</button>
                            </form>
                        </div> 
                    @endforeach
                    

                </div>
            </section>

    </div>
@endsection
