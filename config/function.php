<?php
 function uploadImage($file , $target_dir = "./public/upload/")
{
    $file_name = $file["filename"];

    while (file_exists($target_dir.$file_name) === true) {
        # code...
        $file_name = substr_replace($file_name, substr($file_name,0,strripos($file_name,"."))."_".rand(0,100), 0 , strripos($file_name,"."));
    }
    //upload
    if (move_uploaded_file($file["tmp_name"], $target_dir.$file_name)) {
        return $target_dir.$file_name;
    }
    else {
        return "";
    }
}
function Unlink_file_image($val)
{
    # code...
    $file = "./public/upload/images/".$val;
    if (file_exists($file)) {
        # code...
        unlink($file);
    }
}