<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinGame extends Model
{
    //資料表名稱
    protected $table = 'MinGame';

    public $timestamps = false;

    protected $primarykey = 'id';

    protected $fillable = [
        'account',
    ];
}
