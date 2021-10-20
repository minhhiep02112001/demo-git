<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="./public/admin/img/avatar3.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Hello, Jane</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="{{url()->getPath() == url('admin.home') ?'active':''}}">
                <a href="{{url('admin.home')}}" >
                    <i class="fa fa-dashboard"></i> <span>Trang chủ</span>
                </a>
            </li>
            <li class="{{url()->contains('/order') ?'active':''}}">
                <a href="{{url('order.index')}}">
                    <i class="fa fa-th"></i> <span>Quản lý đặt phòng</span> 
                </a>
            </li>
            <li class="{{url()->contains('/room') ?'active':''}}">
                <a href="{{url('room.index')}}">
                    <i class="fa fa-th"></i> <span>Quản lý phòng</span> 
                </a>
            </li>
            <li class="{{url()->contains('/article') ?'active':''}}">
                <a href="{{url('article.index')}}">
                    <i class="fa fa-th"></i> <span>Quản lý bài viết</span> 
                </a>
            </li>
            <li class="{{url()->contains('/customer') ?'active':''}}">
                <a href="{{url('customer.index')}}">
                    <i class="fa fa-th"></i> <span>Quản lý nhân viên</span> 
                </a>
            </li>
            <li class="{{url()->contains('/user') ?'active':''}}">
                <a href="{{url('user.index')}}">
                    <i class="fa fa-th"></i> <span>Quản lý khách hàng</span> 
                </a>
            </li>
            <li>
                <a href="{{url('admin.logout')}}" class="logout">
                    <i class="fa fa-th"></i> <span>Đăng Xuất</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
