<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyRecognizee extends Model
{
    //被保人信息表
    protected $table = 'warranty_recognizee';

    //订单
    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id','id');
    }

    //证件类型
//    public function recognizee_card_type()
//    {
//        return $this->hasOne('App\Models\CardType','number','card_type');
//    }
//
//    //职业
//    public function recognizee_occupation()
//    {
//        return $this->hasOne('App\Models\Occupation','number','occupation');
//    }
//
//    //关系
//    public function recognizee_relation()
//    {
//        return $this->hasOne('App\Models\Relation','number','relation');
//    }
}
