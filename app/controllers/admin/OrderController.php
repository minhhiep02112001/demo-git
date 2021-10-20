<?php


namespace App\controllers\admin;


use App\core\Pagination;
use App\models\Customer;
use App\models\Order;
use Jenssegers\Blade\Blade;

class OrderController
{
    function index(){
        $page = ($_REQUEST['page']) ?? 1;
        $limit = 10;
        $order = Order::offset(($page - 1) * $limit)->limit($limit)->get();

        $total = Customer::count();
        unset($_REQUEST['url'], $_REQUEST['page']);

        if (count($_REQUEST) > 0) {
            $param = "";
            foreach ($_REQUEST as $key => $value) {
                $param .= "&{$key}={$value}";
            }
        }

        $config = [
            'total' => $total,
            'limit' => 10,
            'url' => rtrim(url('order.index')->getPath(), '/'),
            'full' => false, //bỏ qua nếu không muốn hiển thị full page
            'param' => $param ?? ""
        ];

        $page = new Pagination($config);

        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.order.index', [
            'order' => $order,
            'page' => $page
        ]);

    }

    function show($id){
        $order = Order::find($id);

        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.order.invoice', [
            'order'=>$order,

        ]);
    }
    function update($id){

        $order = Order::find($id);
        $data = [];
        $data['status'] = input('status');
        if(input()->exists('content')){
            $data['contents'] = input('content');
        }
        $order->update($data);
        $_SESSION['success'] = [
            'status' => 'Success !!!'
        ];
        return redirect(url('order.index'));
    }
}