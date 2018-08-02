<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderBrokerage extends Model
{
    //订单佣金表
    protected $table = 'order_brokerage';

    //佣金和订单关联
//    public function order_brokerage_order()
//    {
//        return $this->belongsTo('App\Models\Order','order_id','id');
//    }
//    //佣金和渠道的关系
//    public function order_brokerage_ditch()
//    {
//        return $this->hasOne('App\Models\Ditch','id','ditch_id');
//    }
//    //佣金和用户的关系
//    public function order_brokerage_agents()
//    {
//        return $this->hasOne('App\Models\Agent','id','agent_id');
//    }
//    //佣金和代理人的关系
//    public function order_brokerage_user()
//    {
//        return $this->hasOne('App\Models\User','id','agent_id');
//    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'ty_product_id', 'ty_product_id');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    public function company_brokerage()
    {
        return $this->hasMany('App\Models\CompanyBrokerage','order_id','order_id');
    }

}
