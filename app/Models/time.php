<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class time extends Model
{
    //資料表名稱
    protected $table = 'time';

    protected $primarykey = 'tid';

    protected $fillable = [
        'tid', 'mid', 'hall', 'time', 'seat', 'created_at', 'updated_at'
    ];
}
