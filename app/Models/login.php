<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class login extends Model
{
    //資料表名稱
    protected $table = 'user';

    // public $timestamps = false;

    protected $primarykey = 'Uid';

    protected $fillable = [
        'account', 'password',
    ];
}
