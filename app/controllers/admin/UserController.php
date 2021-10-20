<?php


namespace App\controllers\admin;


use App\core\Pagination;
use App\validate\UniqueEditValidate;
use App\validate\UniqueValidate;
use App\Models\User;
use Jenssegers\Blade\Blade;
use Rakit\Validation\Validator;

class UserController
{
    function index()
    {
        $page = ($_REQUEST['page']) ?? 1;
        $limit = 10;
        $start = ( $page - 1 ) * $limit;
        $user = User::offset($start)->limit($limit)->get();
        $total = User::count();
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
            'url' => rtrim(url('user.index')->getPath(), '/'),
            'full' => false, //bỏ qua nếu không muốn hiển thị full page
            'param' => $param ?? ""
        ];

        $page = new Pagination($config);

        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.user.index', [
            'users' => $user,
            'page' => $page,
            'start' => $start
        ]);

    }

    public function create()
    {
        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.user.create');
    }

    public function store()
    {

        $validator = new Validator;
        $validator->addValidator('unique', new UniqueValidate());
        $validation = $validator->validate($_POST + $_FILES, [
            'name' => 'required',
            'phone' => 'required|unique:user,phone',
            'email' => 'required|email|unique:user,email',
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
            $image =  uploadImage(input()->file('image')->toArray() , './public/upload/user/');
        }
        $data['image'] = $image??'';
        $data['active'] = input('active') ?? 0;
        $data['password'] = md5(input('password'));
        $user = User::create($data);
        $_SESSION['success'] = [
            'status' => 'Success !!!'
        ];
        return redirect(url('user.index'));
    }
    public function edit($id){
        $user = User::find($id);
        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.user.edit', [
            'user' => $user
        ]);
    }

    public function update($id){

        $user = User::find($id);

        $validator = new Validator;
        $validator->addValidator('unique', new UniqueEditValidate());
        $validation = $validator->validate($_POST + $_FILES, [
            'name' => 'required',
            'phone' => 'required|unique:customer,phone,'.$id,
            'email' => 'required|email|unique:user,email,'.$id,
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
            $image =  uploadImage(input()->file('image')->toArray() , './public/upload/user/');
            $data['image'] = $image;
            @unlink($user->image);
        }

        $data['active'] = input('active') ?? 0;
        if(input()->exists('password')){
            $data['password'] = md5(input('password'));
        }
        $user->update($data);
        $_SESSION['success'] = [
            'status' => 'Success !!!'
        ];
        return redirect(url('user.index'));
    }

    function destroy($id){
        $user = User::find($id);
        $image = $user->image;
        if($user->delete()){
            @unlink($image);
            return response()->json(['status'=>'true']);
        }
        return response()->json(['status'=>'false']);
    }
}