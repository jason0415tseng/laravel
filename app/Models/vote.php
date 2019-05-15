<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vote extends Model
{
    //資料表名稱
    protected $table = 'vote';

    protected $primarykey = 'vid';

    protected $fillable = [
        'vid', 'voteaid',  'voteacid', 'voteaccount', 'voteip', 'created_at', 'updated_at'
    ];
}
