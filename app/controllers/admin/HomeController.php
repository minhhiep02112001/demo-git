<?php


namespace App\controllers\admin;


use Jenssegers\Blade\Blade;

class HomeController
{
    function index(){
        $view = new Blade('app/views', 'app/cache');
        return $view->render('admin.home.index');
    }
}