<?php

use App\core\CsrfTokenBase;
use App\core\SessionTokenProvider;
use Pecee\Http\Middleware\Exceptions\TokenMismatchException;
use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter as Route;




Route::group([  'exceptionHandler'=>\App\handlers\CustomExceptionHandler::class ] , function (){
    Route::csrfVerifier(new CsrfTokenBase()); // kiểm tra token trong form submit lên server

    Route::get( '/dang-ky' , [\App\controllers\UserController::class , 'index']);
    Route::post( '/register' , [\App\controllers\UserController::class , 'register'])->name('register');
//    Route::get ( '/user/{id}' , function ( $userId ) {
//        return  'Người dùng có id:' . $userId ;
//    });
//
//
//
//    Route::post( '/register' , [\App\controllers\UserController::class , 'register'])->name('register');
//
//    Route::get ( '/admin' , [\App\controllers\UserController::class , 'index']);

   Route::group(['prefix'=>'admin' ,'namespace'=>'\App\controllers\admin' ], function(){
        Route::get('/login' , 'AuthController@login')->name('admin.login');
        Route::post('/login' , 'AuthController@postLogin')->name('admin.login.post');
        Route::get('/logout' , 'AuthController@logout')->name('admin.logout');

        Route::group(['middleware' => \App\middleware\CheckAdminLogin::class], function (){

            Route::get('/' , 'HomeController@index')->name('admin.home');

            Route::group(['prefix'=>'user' ] , function (){
                Route::get('/' ,'UserController@index')->name('user.index');
                Route::get('/create' , 'UserController@create')->name('user.create');
                Route::post('/create' , 'UserController@store')->name('user.store');
                Route::get('/{id}/edit' , 'UserController@edit')->name('user.edit');
                Route::post('/{id}/edit' , 'UserController@update')->name('user.update');
                Route::delete('/{id}', 'UserController@destroy')->name('user.destroy');
            });
            Route::group(['prefix'=>'customer' ] , function (){
                Route::get('/' , 'CustomerController@index')->name('customer.index');
                Route::get('/create' , 'CustomerController@create')->name('customer.create');
                Route::post('/create' , 'CustomerController@store')->name('customer.store');
                Route::get('/{id}/edit' , 'CustomerController@edit')->name('customer.edit');
                Route::post('/{id}/edit' , 'CustomerController@update')->name('customer.update');
                Route::delete('/{id}', 'CustomerController@destroy')->name('customer.destroy');
            });
            // route bài viết
            Route::group(['prefix'=>'article' ] , function (){
                Route::get('/' , 'ArticleController@index')->name('article.index');
                Route::get('/create' , 'ArticleController@create')->name('article.create');
                Route::post('/create' , 'ArticleController@store')->name('article.store');
                Route::get('/{id}/edit' , 'ArticleController@edit')->name('article.edit');
                Route::post('/{id}/edit' , 'ArticleController@update')->name('article.update');
                Route::delete('/{id}', 'ArticleController@destroy')->name('article.destroy');
            });

           Route::group(['prefix'=>'room'] , function (){
               Route::get('/' , 'RoomController@index')->name('room.index');
               Route::get('/create' , 'RoomController@create')->name('room.create');
               Route::post('/create' , 'RoomController@store')->name('room.store');
               Route::get('/{id}/edit' , 'RoomController@edit')->name('room.edit');
               Route::post('/{id}/edit' , 'RoomController@update')->name('room.update');
               Route::delete('/{id}', 'RoomController@destroy')->name('room.destroy');
           });

           Route::group(['prefix'=>'order'] , function (){
               Route::get('/' , 'OrderController@index')->name('order.index');
               Route::get('/{id}' , 'OrderController@show')->name('order.show');
               Route::post('/{id}' , 'OrderController@update')->name('order.update');
           });
        });
   });


});
Route::start();

