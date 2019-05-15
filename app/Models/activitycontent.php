<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class activitycontent extends Model
{
    //資料表名稱
    protected $table = 'activitycontent';

    protected $primarykey = 'acid';

    protected $fillable = [
        'acid', 'aid', 'content', 'votenumber', 'created_at', 'updated_at'
    ];
}
