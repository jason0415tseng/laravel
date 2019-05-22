<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    //資料表名稱
    protected $table = 'order';

    protected $primarykey = 'oid';

    protected $fillable = [
        'oid', 'ordernumber', 'ordermid', 'orderhall', 'ordertime', 'orderticket', 'orderseat', 'orderuid', 'orderaccount', 'ordername', 'created_at', 'updated_at'
    ];
}
