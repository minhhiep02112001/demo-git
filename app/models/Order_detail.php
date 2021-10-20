<?php


namespace App\models;


use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    protected $table='order_detail';
    protected $fillable = ['order_id', 'room_id', 'price', 'count_people'];
    public  function  room(){
        return $this->belongsTo(Room::class , 'room_id' , 'id' );
    }
    public  function  order(){
        return $this->belongsTo(Order::class , 'order_id' , 'id' );
    }
}