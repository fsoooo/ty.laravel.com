<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCondition extends Model
{
    //任务条件表
    protected $table = 'task_condition';


    public function task_product()
    {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function task_area()
    {
//        return $this->belongsTo('App\M')
    }
    
}
