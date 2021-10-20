@extends('admin.layout.__index')
@section('title')
    <title>Quản lý đặt phòng</title>
@endsection

@section('css')
    <style>
        .dat-phong{
            list-style: none;
        }
        .dat-phong li{
            padding-bottom: 10px;
        }
        @media print {
            .noPrint{
                display:none;
            }
        }
    </style>
@endsection

@section('content')


    <!-- Main content -->
    <section class="content invoice" style="width: 60%;">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Thông tin đơn đặt phòng
                    <small class="pull-right">Ngày : {{date("d/m/Y")}}</small>
                </h2>
            </div>
            <!-- /.col -->
            <div class="col-xs-12">
                <div class="infomation">
                    <ul class="dat-phong">
                        <li> <b>Họ tên</b> : {{$order->user->name}}</li>
                        <li> <b>Email</b> : {{$order->user->email}}</li>
                        <li> <b>Số điện thoại</b> : {{$order->user->phone}}</li>
                        <li style="margin-bottom: 0px;"> <b>Trạng thái </b> : Đặt phòng</li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 table-responsive">
                <h3 class="text-center" style="margin-top: 5px;">Thông tin phòng</h3>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th width="30%">Phòng</th>
                        <th class="text-center">Hình ảnh</th>
                        <th>Giá/ngày</th>
                        <th>Ngày đến</th>
                        <th>Ngày đi</th>
                        <th>Tổng tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->order_detail()->get() as $key=>$value)
                        <tr>
                            <td>{{$value->room->title}}</td>
                            <td>
                                <div style="width: 80px; height: 80px ; overflow: hidden; border-radius: 5px ; border: 1px solid; margin: 0 auto;">
                                    <img src="{{$value->room->image}}" style="width: 100%;height: 100%;" alt="">
                                </div>
                            </td>

                            <td>{{number_format($value->room->price)}} đ</td>
                            <td class="text-center">{{date("d-m-Y", strtotime( $order->start ))}}</td>
                            <td class="text-center">{{date("d-m-Y", strtotime( $order->end ))}}</td>
                            <td class="text-center">{{number_format($order->total , 0 ,',' ,'.')}} đ</td>

                        </tr>
                    @endforeach

                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
                <h3 class="text-right" style="margin-bottom: 25px;">Thanh toán : {{number_format($order->total , 0 ,',' ,'.')}} đ<h3>

            </div>
            <div class="col-xs-12 noPrint" >
                 

                <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
                    <a class="btn btn-success pull-right" style="margin-left: 5px;" href="{{url('order.index')}}"> Quay lại</a>
                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-credit-card"></i> Cập nhật trạng thái</button>

                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Cập nhật trạng thái đơn hàng : </h4>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('order.update',['id'=>$order->id])}}" id="form-update-status" method="post">
                                    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
                                    <div class="form-group">
                                        <label>Trạng thái đơn : </label>
                                        <select class="form-control" id="select-status-order" name="status">
                                            <option value="0" {{$order->status == 0 ? 'selected':""}}>Đặt hàng</option>
                                            <option value="1" {{$order->status == 1 ? 'selected':""}}>Thành công</option>
                                            <option value="2" {{$order->status == 2 ? 'selected':""}}>Thanh toán</option>
                                            <option value="3" {{$order->status == 3 ? 'selected':""}} class="cancel-order">Hủy</option>
                                            <option value="4" {{$order->status == 4 ? 'selected':""}} class="cancel-order">Khách hàng hủy</option>
                                        </select>
                                    </div>
                                    <div class="form-group reason-cancel-order">
                                        <label>Lý do : </label>
                                        <textarea class="form-control" rows="3" required name="content" placeholder="Lý do ...."></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary btn-update-form-status"  >Cập nhật</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </section><!-- /.content -->

@endsection

@section('js')
    <!-- DATA TABES SCRIPT -->
    <script src="./public/admin/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="./public/admin/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="./public/admin/js/AdminLTE/app.js" type="text/javascript"></script>

    <script>
        $(function() {
            $('.reason-cancel-order').fadeOut();
            $(document).on('change' , '#select-status-order', function () {
                if($(this).val()==3 || $(this).val()==4){
                    $('.reason-cancel-order').fadeIn(2000);
                }else{
                    $('.reason-cancel-order').fadeOut();
                }
            });
            $('.btn-update-form-status').click(function () {
                $("#form-update-status").submit();
            })
        })
    </script>
@endsection