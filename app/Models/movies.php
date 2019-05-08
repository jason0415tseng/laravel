<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class movies extends Model
{
    //資料表名稱
    protected $table = 'movies';

    protected $primarykey = 'mid';

    protected $fillable = [
        'mid', 'name', 'name_en', 'ondate', 'type', 'length', 'grade', 'director', 'actor', 'poster', 'introduction', 'display', 'created_at', 'updated_at'
    ];
}
