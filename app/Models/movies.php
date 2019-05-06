<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class movies extends Model
{
    //資料表名稱
    protected $table = 'movies';

    // public $timestamps = false;

    protected $primarykey = 'id';

    protected $fillable = [
        'id', 'name', 'name_en', 'ondate', 'type', 'length', 'grade', 'director', 'actor', 'poster', 'introduction', 'display', 'seq', 'created_at', 'updated_at'
    ];
}
