@extends('admin.layout.__index')
@section('title')
    <title>Quản lý thống kê</title>
@endsection

@section('css')

@endsection

@section('content')


    <section class="content-header">
        <h1>
            Trang chủ
        </h1>

    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header" >

                        <h4>Trang chủ </h4>

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

                    </div><!-- /.box-body -->
                    {{--                    <div class="box-footer clearfix">--}}
                    {{--                        {!! $page->getPagination() !!}--}}
                    {{--                    </div>--}}
                </div>
            </div>
        </div>

    </section>
@endsection

@section('js')
@endsection