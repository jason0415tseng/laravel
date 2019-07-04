<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class apilog extends Model
{
    //資料表名稱
    protected $table = 'apilog';

    protected $primarykey = 'id';

    protected $fillable = [
        '_index', '_type',  '_id', 'server_name', 'request_method', 'status', 'size', 'timestamp',
    ];
}
