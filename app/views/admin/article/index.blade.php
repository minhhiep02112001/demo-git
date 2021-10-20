@extends('admin.layout.__index')
@section('title')
    <title>Quản lý khách hàng - Danh sách</title>
@endsection

@section('css')

@endsection

@section('content')

    @php
        if(isset($_SESSION['success'])){
            extract($_SESSION['success']);
            unset($_SESSION['success']);
        }
    @endphp


    <section class="content-header">
        <h1>
            Danh sách bài viết
        </h1>
        <ol class="breadcrumb">
            <a href="{{url('article.create')}}" class="btn btn-success btn-sm" style="color: #fff">Thêm bài viết</a>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header" >

                            <h4>Search </h4>

                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="status">
                            @isset($status)

                                <div class="alert alert-success alert-dismissable">
                                    <i class="fa fa-check"></i>
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <b>{{$status}}!</b>
                                </div>

                            @endisset
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th style="width: 80px;">Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Mô tả ngắn</th>
                                <th width="8%">Lượt xem</th>
                                <th width="8%">Nổi bật</th>
                                <th width="8%">Trạng thái</th>
                                <th style="width: 80px; box-sizing: content-box">Hành động</th>
                            </tr>

                            @if(count($article) > 0)
                                @foreach($article as $key=>$item)
                                    <tr>
                                        <td>{{ ++$start}}</td>
                                        <td>
                                            <div class="image" style="margin:0 auto;width: 50px ; height: 50px; overflow:hidden; border: 1px solid ; border-radius: 5px;">
                                                <img style="width: 100%; height: 100%;" src="{{$item->image ?? ''}}">
                                            </div>
                                        </td>
                                        <td>{{$item->title}}</td>
                                        <td>
                                            {!! $item->summary !!}
                                        </td>
                                        <td class="text-center">{{$item->view}}</td>
                                        <td class="text-center">
                                            {!! $item->is_hot ? '<span class="badge bg-green">có</span>' : '<span class="badge bg-red">không</span>'!!}
                                        </td>
                                        <td class="text-center">
                                            {!! $item->active ? '<span class="badge bg-green">kích hoạt</span>' : '<span class="badge bg-red">khóa</span>'!!}
                                        </td>
                                        <td>
                                            <a class="btn btn-warning btn-xs" href="{{url('article.edit' ,['id' => $item->id])}}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-xs btn-sm btn-danger btn-delete" data-id="{{ $item->id }}" data-model="article">
                                                <i class="fa fa-times"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <p class="text-center">Không tồn tại bản ghi nào</p>
                                    </td>
                                </tr>
                            @endif


                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        {!! $page->getPagination() !!}
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection

@section('js')
    <!-- DATA TABES SCRIPT -->
    <script src="./public/admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="./public/admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="./public/admin/js/AdminLTE/app.js" type="text/javascript"></script>

    <!-- page script -->
    <script type="text/javascript">
        // $.extend( $.fn.dataTable.defaults, {
        //     ordering:  false
        // } );
        $(function () {
            $("#example1").dataTable({
                ordering: false,

            });
            // $('#example2').dataTable({
            //     "bPaginate": true,
            //     "bLengthChange": false,
            //     "bFilter": false,
            //     "bSort": false,
            //     "bInfo": true,
            //     "bAutoWidth": false
            // });
        });
    </script>
@endsection