<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class apiwagers extends Model
{
    //資料表名稱
    protected $table = 'apiwagers';

    protected $primarykey = 'id';

    protected $fillable = [
        '_index', '_type',  '_id', 'server_name', 'request_method', 'status', 'size', 'timestamp',
    ];
}
