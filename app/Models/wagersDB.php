<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class wagersDB extends Model
{
    //資料表名稱
    protected $table = 'wagers';

    protected $primarykey = 'id';

    protected $fillable = [
        'gameid', 'uid',  'account', 'betnumber', 'lottery', 'betgold', 'wingold', 'bettime',
    ];
}
