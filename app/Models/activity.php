<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    //資料表名稱
    protected $table = 'activity';

    protected $primarykey = 'aid';

    protected $fillable = [
        'aid', 'title', 'author', 'startdate', 'enddate', 'activitycontent.votenumber', 'created_at', 'updated_at'
    ];
}
