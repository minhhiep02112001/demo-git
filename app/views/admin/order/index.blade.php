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
            Danh sách đặt phòng
        </h1>

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
                                <th style="width: 10%;">Mã code</th>
                                <th class="text-center">Trạng thái</th>
                                <th>Tên người thuê</th>
                                <th>Email</th>
                                <th width="10%">Số điện thoại</th>
                                <th width="10%" class="text-center">Giá tiền</th>
                                <th width="10%" class="text-center">Ngày bắt đầu</th>
                                <th width="10%" class="text-center">Ngày kết thúc</th>

                                <th width="8%">Hành động</th>
                            </tr>

                            @if( count($order) > 0)
                                @foreach($order as $key=>$item)
                                    <tr>
                                        <td>1.</td>
                                        <td>
                                            {{$item->code}}
                                        </td>
                                        <td class="text-center">
                                            @if($item->status == 0)
                                                <span class="btn btn-flat" style="padding: 5px 10px; background: #e08e0b; color: #fff">Đặt phòng</span>
                                            @elseif($item->status ==1)
                                                <span class=" btn-flat" style="padding: 5px 10px; background: #00acd6;color: #fff; ">Thành công</span>
                                            @elseif($item->status ==2)
                                                <span class="btn  btn-flat" style="padding: 5px 10px; background: #008d4c;color: #fff; ">Đã thanh toán</span>
                                            @elseif($item->status ==3)
                                                <span class="btn btn-flat" style="padding: 5px 10px; background: #f4543c;color: #fff; ">Nhân viên hủy</span>
                                            @else
                                                <span class="btn btn-flat" style="padding: 5px 10px; background: #f4543c; color: #fff;">Khách hàng hủy</span>
                                            @endif
                                        </td>
                                        <td>{{$item->user->name}}</td>
                                        <td>{{$item->user->email}}</td>
                                        <td>{{$item->user->phone}}</td>
                                        <td class="text-center">{{number_format($item->total , 0 ,',' ,'.')}} đ</td>
                                        <td class="text-center">{{date("m-d-Y", strtotime( $item->start ))}}</td>
                                        <td class="text-center">{{date("m-d-Y", strtotime( $item->end ))}}</td>
                                        <td class="text-center">
                                            <a href="{{url('order.show',['id'=>$item->id])}}" class="btn btn-info">chi tiết</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10">
                                        <p class="text-center">Không tồn tại bản ghi nào</p>
                                    </td>
                                </tr>
                            @endif


                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
{{--                    <div class="box-footer clearfix">--}}
{{--                        {!! $page->getPagination() !!}--}}
{{--                    </div>--}}
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