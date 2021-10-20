<?php


namespace App\middleware;


use App\Models\User;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class ValidateIdMiddleware implements IMiddleware
{
    public function handle(Request $request): void
    {
        echo 'chạy qua middleware';
        exit();
         die('exit');
    }
}