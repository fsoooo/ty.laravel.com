<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ditch extends Model
{
    protected $table="ditches";

    //many to many 渠道关联代理人
    public function agents()
    {
        return $this->belongsToMany('App\Models\Agent','ditch_agent','ditch_id', 'agent_id');
    }

    //渠道关联任务  （已经没有这个表了）
    public function task_ditch()
    {
        return $this->belongsToMany('App\Models\Task','task_ditch','ditch_id', 'task_id');
    }

    public function brokerage()
    {
        return $this->hasMany('App\Models\MarketDitchRelation', 'ditch_id', 'id')->where('agent_id', 0);
    }

    //渠道关联任务
    public function task_detail()
    {
        return $this->hasMany('App\Models\TaskDetail','ditch_id','id');
    }

    //代理人佣金
    public function order_brokerage(){
        return $this->hasMany('App\Models\OrderBrokerage','ditch_id','id');
    }

    //某一渠道的代理人
    public function agent()
    {
        return $this->hasMany('App\Models\Agent','agent_id','id');
    }
    //活跃产品中间表
    public function warranty_rule()
    {
        return $this->hasMany('App\Models\Warranty','warranty_id','id');
    }

}
