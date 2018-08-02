<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table="agents";

    //many to many
    public function ditches()
    {
        return $this->belongsToMany('App\Models\Ditch','ditch_agent','agent_id','ditch_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    //代理佣金记录
    public function orderBrokerage()
    {
        return $this->hasMany('App\Models\OrderBrokerage', 'agent_id', 'id');
    }

    //代理人订单
    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'agent_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany('App\Models\CustRule', 'agent_id', 'id');
    }

    public function taskDetail()
    {
        return $this->hasMany('App\Models\TaskDetail', 'agent_id', 'id');
    }
}
