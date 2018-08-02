<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyRule extends Model
{
    //订单保单关联表
    protected $table = 'warranty_rule';

    //保全
//    public function warranty_maintenance_info()
//    {
//        return $this->hasOne('App\Models\MaintenanceInfo','union_order_code','union_order_id');
//    }

    //产品 old
    public function warranty_product()
    {
        return $this->hasOne('App\Models\Product','private_p_code','private_p_code');
    }

    //关联产品通过ty_product_id
    public function warranty_rule_product()
    {
        return $this->hasOne('App\Models\Product','ty_product_id','ty_product_id');
    }

    //订单 old
    public function warranty_rule_order()
    {
        return $this->hasOne('App\Models\Order','id','order_id');
    }

    //关联保单
    public function warranty()
    {
        return $this->hasOne('App\Models\Warranty','id','warranty_id');
    }

    //投保人
    public function policy(){
        return $this->hasOne('App\Models\WarrantyPolicy','id','policy_id');
    }

    //受益人
    public function beneficiary(){
        return $this->hasOne('App\Models\WarrantyBeneficiary','id','beneficiary_id');
    }


    //产品
    public function product()
    {
        return $this->hasOne('App\Models\Product','ty_product_id','ty_product_id');
    }

    //订单
    public function order()
    {
        return $this->hasOne('App\Models\Order','id','order_id');
    }

    //订单
    public function agent()
    {
        return $this->hasOne('App\Models\Agent','id','agent_id');
    }

    //渠道代理人佣金
    public function brokerage()
    {
        return $this->hasOne('App\Models\OrderBrokerage','order_id','order_id');
    }




}
