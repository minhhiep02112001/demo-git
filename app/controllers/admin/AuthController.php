<?php


namespace App\controllers\admin;


use App\models\Customer;
use App\validate\UniqueValidate;
use Jenssegers\Blade\Blade;
use Rakit\Validation\Validator;

class AuthController
{

    function login(){
        if(isset($_SESSION['auth.admin'])){
            return redirect(url('admin.home'));
        }
        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.auth.login');
    }
    function postLogin(){
        $validator = new Validator();
        $validation = $validator->validate($_POST  , [
            'email' => 'required|email',
            'password' => 'required|min:6',

        ]);
        if ($validation->fails()) {
            $errors = [];
            $errors['old'] = input()->all();
            $error = $validation->errors();
            $errors['error'] = $error->firstOfAll();
            $_SESSION['validate_data'] = $errors;
            return redirect($_SERVER["HTTP_REFERER"]);
        }
        $user = Customer::where([
            'email'=>input('email'),
            'password' => md5(input('password'))
        ])->first();
        if(! $user){
            $errors = [];
            $errors['old'] = input()->all();
            $errors['error'] = [
                'errors'=>'Tài khoản hoặc mật khẩu không đúng',
            ];
            $_SESSION['validate_data'] = $errors;
            unset($_SESSION['auth.admin']);
            return redirect($_SERVER["HTTP_REFERER"]);

        }
        $_SESSION['auth.admin'] = $user;

        return redirect(url('admin.home'));
    }

    function logout()
    {
        if(isset($_SESSION['auth.admin'])){
            unset($_SESSION['auth.admin']);
        }
        redirect(url('admin.login'));
    }

}