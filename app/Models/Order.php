<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //订单表
    protected $table = 'order';
    //订单关联订单佣金
    public function order_brokerage()
    {
        return $this->hasOne('App\Models\OrderBrokerage','order_id','id');
    }

//    public function warranty_status()
//    {
//        return $this->belongsTo('App\Models\Status','status','id');
//    }


    public function warranty_rule()
    {
        return $this->hasOne('App\Models\WarrantyRule','order_id','id');
    }
    //订单关联活动
//    public function order_competition()
//    {
//        return $this->belongsTo('App\Models\Competition','competition_id','id');
//    }
    //订单关联产品
    public function product(){
        return $this->hasOne('App\Models\Product','ty_product_id','ty_product_id');
    }
    //订单关联产品
    public function product_res(){
        return $this->hasOne('App\Models\Product','private_p_code','private_p_code');
    }
    //关联参数
    public function parameter(){
        return $this->hasOne('App\Models\OrderParameter','order_id','id');
    }

    //关联用户表
    public function order_user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }

    //关联代理人
    public function order_agent()
    {
        return $this->hasOne('App\Models\Agent','id','agent_id');
    }

    public function pro()
    {
        return $this->hasOne('App\Models\Product','private_p_code','private_p_code');
    }

//    public function recognizee()
//    {
//        return $this->hasMany('App\Models\Recognizee','order_id', 'id');
//    }

    //关联被保人信息表
    public function warranty_recognizee()
    {
        return $this->hasMany('App\Models\WarrantyRecognizee','order_id','id');
    }

    public function companyBrokerage()
    {
        return $this->hasOne('App\Models\CompanyBrokerage', 'order_id', 'id');
    }

    public function order_parameter()
    {
        return $this->hasMany('App\Models\OrderParameter','order_id', 'id');
    }

    public function planList()
    {
        return $this->belongsTo('App\Models\PlanLists', 'plan_id', 'id');
    }

    //关联代理人
    public function agent()
    {
        return $this->hasOne('App\Models\Agent','id','agent_id');
    }

    public function order_warranty()
    {
        return $this->belongsToMany(Warranty::class, 'warranty_rule', 'order_id', 'warranty_id');
    }

    public function order_ditch()
    {
        return $this->hasOne('App\Models\Ditch','id','ditch_id');
    }
}
