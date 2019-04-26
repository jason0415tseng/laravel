<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //資料表名稱
    protected $table = 'user';

    // public $timestamps = false;

    protected $primarykey = 'Uid';

    protected $fillable = [
        'uid' , 'level',  'account', 'name', 'freeze' , 'created_at', 'updated_at'
    ];
}
