<?php


namespace App\models;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $fillable = ['name' ,'password' , 'email' , 'image' , 'phone' , 'active'];
    protected $hidden= ['password'];
}