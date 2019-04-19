<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// class News extends Model
// {
//     //
// }

//指定特定的資料表
class News extends Model
{
    protected $table = 'news';
    //create新增，model裡面新增允許的欄位
    protected $fillable = ['title','description'];
}