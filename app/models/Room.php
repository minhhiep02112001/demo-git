<?php


namespace App\models;


use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'room';
    protected $fillable = ['title', 'slug', 'summary', 'details_description', 'image', 'price', 'count_people', 'status', 'active'];
}