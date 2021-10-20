<?php

namespace App\controllers\admin;

use App\core\Pagination;
use App\validate\UniqueEditValidate;
use App\validate\UniqueValidate;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Blade\Blade;
use Rakit\Validation\Validator;

class CustomerController
{
    function index()
    {
        $page = ($_REQUEST['page']) ?? 1;
        $limit = 10; // config
        $start = ( $page - 1 ) * $limit;
        $customer = Customer::offset($start)->limit($limit)->get();
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
            'url' => rtrim(url('Customer.index')->getPath(), '/'),
            'full' => false, //bỏ qua nếu không muốn hiển thị full page
            'param' => $param ?? ""
        ];

        $page = new Pagination($config);
        $view = new Blade('app/views', 'app/cache');

        return $view->render('admin.customer.index', [
            'customer' => $customer,
            'page' => $page,
            'start' => $start
        ]);
    }

    public function create()
    {
        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.customer.create');
    }

    public function store()
    {
        $validator = new Validator;
        $validator->addValidator('unique', new UniqueValidate());
        $validation = $validator->validate($_POST + $_FILES, [
            'name' => 'required',
            'phone' => 'required|unique:customer,phone',
            'email' => 'required|email|unique:customer,email',
            'password' => 'required|min:6',
            'image' => 'required|uploaded_file:0,500K,png,jpg,jpeg',
        ]);

        if ($validation->fails()) {
            $errors = [];
            $errors['old'] = input()->all();
            $error = $validation->errors();
            $errors['error'] = $error->firstOfAll();
            $_SESSION['validate_data'] = $errors;
            return redirect($_SERVER["HTTP_REFERER"]);
        }

        $data = input()->all(['name' , 'email' , 'phone']);

        if( input()->file('image', $defaultValue = null) != null){
            $image =  uploadImage(input()->file('image')->toArray() , './public/upload/customer/');
        }

        $data['image'] = $image??'';
        $data['active'] = input('active') ?? 0;
        $data['password'] = md5(input('password'));
        $customer = Customer::create($data);
        $_SESSION['success'] = [
            'status' => 'Success !!!'
        ];

        return redirect(url('Customer.index'));
    }
    public function edit($id)
    {
        $customer = Customer::find($id);
        $view = new Blade('app/views', 'app/cache');

        return $view->render('admin.customer.edit', [
            'customer' => $customer
        ]);
    }

    public function update($id)
    {
        $customer = Customer::find($id);
        $validator = new Validator;
        $validator->addValidator('unique', new UniqueEditValidate());
        $validation = $validator->validate($_POST + $_FILES, [
            'name' => 'required',
            'phone' => 'required|unique:customer,phone,'.$id,
            'email' => 'required|email|unique:customer,email,'.$id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|uploaded_file:0,500K,png,jpg,jpeg',
        ]);

        if ($validation->fails()) {
            $errors = [];
            $errors['old'] = input()->all();
            $error = $validation->errors();
            $errors['error'] = $error->firstOfAll();
            $_SESSION['validate_data'] = $errors;
            return redirect($_SERVER["HTTP_REFERER"]);
        }

        $data = input()->all(['name' , 'email' , 'phone']);

        if( input()->exists('image')){
            $image =  uploadImage(input()->file('image')->toArray() ,'./public/upload/customer/');
            $data['image'] = $image;
            @unlink($customer->image);
        }

        $data['active'] = input('active') ?? 0;
        if(input()->exists('password')){
            $data['password'] = md5(input('password'));
        }
        $customer->update($data);
        $_SESSION['success'] = [
            'status' => 'Success !!!'
        ];

        return redirect(url('Customer.index'));
    }

    function destroy($id)
    {
        $customer = Customer::find($id);
        $image = $customer->image;
        if($customer->delete()){
            @unlink($image);
            return response()->json(['status'=>'true']);
        }

        return response()->json(['status'=>'false']);
    }
}