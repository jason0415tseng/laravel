<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gamegold extends Model
{
    //資料表名稱
    protected $table = 'gamegold';

    protected $primarykey = 'id';

    protected $fillable = [
        'uid', 'gold',
    ];
}
