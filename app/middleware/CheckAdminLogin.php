<?php


namespace App\middleware;


use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class CheckAdminLogin implements IMiddleware
{
    public function handle(Request $request): void
    {
        if(!isset($_SESSION['auth.admin'])){
//            $request->setRewriteUrl(url('admin.login'));
            redirect(url('admin.login'));
        }
    }
}