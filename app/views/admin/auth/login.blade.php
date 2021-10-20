<!DOCTYPE html>
<html class="bg-black">
<head>
    <base href="{{__WEB_ROOT__}}">
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="./public/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="./public/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="./public/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-black">
{{-- @php
    if(isset($_SESSION['validate_data'])){
        extract($_SESSION['validate_data']);
        unset($_SESSION['validate_data']);
    }
@endphp --}}
<div class="form-box" id="login-box">
    <div class="header">Đăng nhập</div>
    <form action="{{url('admin.login.post')}}" method="post">
       
        <div class="body bg-gray">
           {{--  @isset($error)
                <div class="alert alert-danger alert-dismissable" style="margin-left: 0px; margin-top: 15px; padding: 10px;">

                    <button type="button" class="close" style="right: 2px;" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Error !</b>
                    <ul style="padding-left: 20px;">
                        @foreach($error as $val)
                            <li>{{$val}} </li>
                        @endforeach
                    </ul>
                </div>
            @endisset --}}
            <div class="form-group">
                <input type="text" name="email" class="form-control" value="{{$old['email']??''}}" placeholder="Email"/>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password"/>
            </div>

        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block">Đăng nhập</button>

        </div>
    </form>
</div>


<!-- jQuery 2.0.2 -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./public/admin/js/bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
    $(document).ready(function (){
        $('form').submit(function(){
            $.LoadingOverlay("show");
        });
    })
</script>
</body>
</html>