<?php
session_start();
define('_DIR_ROOT',__DIR__);
if(!empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] =='on'){
    $web_root='https://'.$_SERVER['HTTP_HOST'];
}
$web_root = 'http://'.$_SERVER['HTTP_HOST'];

//$folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']) , '' , strtolower(_DIR_ROOT));
//echo $folder;
define('__WEB_ROOT__' , $web_root);

require __DIR__ . './vendor/autoload.php';
require __DIR__.'./config/database.php';
require_once __DIR__."/bootstrap.php";
require_once __DIR__.'/routes/web.php';
/**
 * The default namespace for route-callbacks, so we don't have to specify it each time.
 * Can be overwritten by using the namespace config option on your routes.
 */

