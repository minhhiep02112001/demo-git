@extends('admin.layout.__index')
@section('title')
    <title>Quản lý khách hàng - Danh sách</title>
@endsection

@section('css')

@endsection

@section('content')
    <section class="content-header">
        <h1>
            Sửa phòng
        </h1>
        <ol class="breadcrumb">
            <a href="{{url('room.index')}}" class="btn btn-success btn-sm" style="color: #fff">Danh sách phòng</a>
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
            <div class="col-md-8">
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
                    <form role="form" action="{{url('room.update' , ['id'=>$room->id])}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề :</label>
                                <input type="text" class="form-control" name="title" value="{{$old['title']??$room->title}}"
                                       id="exampleInputEmail1" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá phòng :</label>
                                <input type="number" class="form-control" name="price" value="{{$old['price']??$room->price}}" placeholder="Enter price">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số người ở :</label>
                                <input type="number" class="form-control"  name="count_people" value="{{$old['count_people']??$room->count_people}}" placeholder="Enter price">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Hình ảnh</label>
                                <input type="file" name="image" id="file-image-upload">
                                <div class="content-image-upload" style="overflow:hidden ;width: 70px ; height: 70px;border-radius: 5px ; border: 1px solid; margin-top: 10px;">
                                    <img id="image-upload" src="{{$room->image}}" width="100%" height="100%"  alt="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả ngắn :</label>
                                <textarea class="form-control" name="summary" id="summary" rows="6"> {{$old['summary']??$room->summary}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Mô tả chi tiết :</label>
                                <textarea class="form-control" name="details_description" id="details_description">
                                    {{$old['details_description']??$room->details_description}}
                                </textarea>

                            </div>
                            <div>
                                <label>
                                    <input type="checkbox" name="status"
                                           value="1" {{$room->status ? 'checked' : ''}} {{isset($old['status']) ? 'checked' : ''}}> Đã đặt
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input type="checkbox" name="active"
                                           value="1" {{$room->active ? 'checked' : ''}}{{isset($old['active']) ? 'checked' : ''}}> Hiển thị
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
    {{--    <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>--}}
    <script src="./public/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="./public/plugins/ckfinder/ckfinder.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(function() {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('details_description' , {
                filebrowserBrowseUrl: "./public/plugins/ckfinder/ckfinder.html",
                filebrowserUploadUrl: "./public/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Files')"}
            );
            // CKEDITOR.replace('summary');
        });

    </script>
@endsection