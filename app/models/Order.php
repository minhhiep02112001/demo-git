<?php


namespace App\models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = ['code', 'user_id', 'total', 'status', 'start', 'end', 'contents'];
    public  function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
    public  function order_detail(){
        return $this->hasMany(Order_detail::class , 'order_id' , 'id');
    }

}