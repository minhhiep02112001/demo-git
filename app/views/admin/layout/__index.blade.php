<!DOCTYPE html>
<html>
<head>
    <base href="{{__WEB_ROOT__}}">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?= csrf_token(); ?>">
    @yield('title')
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="./public/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="./public/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="./public/admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="./public/admin/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="./public/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    
    @yield('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond../public/admin/js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-black">
@include('admin.layout.__header')

<div class="wrapper row-offcanvas row-offcanvas-left">
    @include('admin.layout.__sidebar')
    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        @yield('content')
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

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
        $('.logout').click(function (event) {

            if(!confirm("Bạn có muốn đăng xuất không !!!")){
                event.preventDefault();
                return false
            }

        })
    })
    $(document).on('change' , '#file-image-upload' , function () {
        var _lastimg = $(this);

        if (_lastimg != '') {
            //console.log(_lastimg);
            uploadImg(_lastimg);
        }
    })
    function uploadImg(el) {
        var file_data = $(el).prop('files')[0];
        var type = file_data.type;
        var fileToLoad = file_data;
        console.log(file_data);
        var fileReader = new FileReader();

        fileReader.onload = function(fileLoadedEvent) {
            var srcData = fileLoadedEvent.target.result;
            $('#image-upload').attr('src', srcData);
        }
        fileReader.readAsDataURL(fileToLoad);

    }

    //Ajax :
    jQuery(document).ready(function(){
        // Xóa dữ liệu bảng trong php admin :
        $('.btn-delete').click(function(event){
            event.preventDefault();
            var id = $(this).data('id');
            var model = $(this).data('model');
            var self = $(this);
            if(confirm('Bạn có chắc muốn xóa không ???')){
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/admin/'+model+'/'+id,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        id: id,
                    },
                    success:function(data){
                        let _html = `<div class="alert alert-success alert-dismissable">
                                    <i class="fa fa-check"></i>
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <b>Success !!!</b>
                                </div>`;
                        $(".status").html(_html);
                        self.closest("tr").remove();
                    },
                    error:function(data){
                        alert("Lỗi !!!");
                    }
                });
            }
        });
    });

</script>
@yield('js')
</body>
</html>