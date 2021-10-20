<?php


namespace App\models;


use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';
    protected $fillable = [ 'title', 'slug', 'summary', 'image', 'details_description', 'is_hot', 'active'];
}