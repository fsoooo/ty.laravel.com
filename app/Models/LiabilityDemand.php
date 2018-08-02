<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiabilityDemand extends Model
{
    //需求申请表
    protected $table = 'liability_demand';
    //和用户表关联
    public function demand_user()
    {
        return $this->belongsTo('App\Models\User','create_user_id','id');
    }
    //和代理人表关联
    public function demand_agent()
    {
        return $this->belongsToMany('App\Models\User','agents','id','user_id');
    }
    
    //多对多
    public function comments()
    {
        return $this->morphMany('App\Models\Comment','commentable');
    }
}
