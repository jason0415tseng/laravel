<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class betlog extends Model
{
    //資料表名稱
    protected $table = 'betlog';

    protected $primarykey = 'id';

    protected $fillable = [
        'gameid', 'uid',  'account', 'betnumber', 'lottery', 'betgold', 'wingold', 'bettime',
    ];
}
