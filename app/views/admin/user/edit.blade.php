@extends('admin.layout.__index')
@section('title')
    <title>Quản lý khách hàng - Danh sách</title>
@endsection

@section('css')

@endsection

@section('content')
    <section class="content-header">
        <h1>
            Sửa khách hàng
        </h1>
        <ol class="breadcrumb">
            <a href="{{url('user.index')}}" class="btn btn-success btn-sm" style="color: #fff">Danh sách khách hàng</a>
        </ol>
    </section>
    <!-- Main content -->
    @php
        if(isset($_SESSION['validate_data'])){
            extract($_SESSION['validate_data']);
            unset($_SESSION['validate_data']);
        }
    @endphp


    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    @isset($error)
                        <div class="alert alert-danger alert-dismissable" style="margin-right: 12px; margin-top: 15px;">
                            <i class="fa fa-ban"></i>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <b>Error !</b>
                            <ul style="padding-left: 20px;">
                                @foreach($error as $val)
                                    <li>{{$val}} </li>
                                @endforeach
                            </ul>
                        </div>
                @endisset
                <!-- form start -->
                    <form role="form" action="{{url('user.update',['id'=>$user->id])}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Họ và tên :</label>
                                <input type="text" class="form-control" name="name" value="{{$old['name']??$user->name}}"
                                       id="exampleInputEmail1" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email :</label>
                                <input type="email" class="form-control" name="email" value="{{$old['email'] ?? $user->email}}"
                                       id="exampleInputEmail1" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số điện thoại :</label>
                                <input type="number" class="form-control" name="phone" value="{{$old['phone'] ?? $user->phone}}"
                                       id="exampleInputEmail1" placeholder="Enter phone">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" name="password" id="exampleInputPassword1"
                                       placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Image</label>
                                <input type="file" name="image" id="file-image-upload">
                                <div class="content-image-upload" style="overflow:hidden ;width: 70px ; height: 70px;border-radius: 5px ; border: 1px solid; margin-top: 10px;">
                                    <img id="image-upload" src="{{$user->image}}" width="100%" height="100%"  alt="">
                                </div>
                            </div>
                            <div>
                                <label>
                                    <input type="checkbox" name="active"
                                           value="1" {{$user->active?'checked':''}} {{isset($old['active']) ? 'checked' : ''}}> Kích hoạt
                                </label>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div><!-- /.box -->


            </div>
        </div><!-- /.row -->

    </section>
    <!-- /.content -->
@endsection

@section('js')

    <script src="./public/admin/js/AdminLTE/app.js" type="text/javascript"></script>


@endsection