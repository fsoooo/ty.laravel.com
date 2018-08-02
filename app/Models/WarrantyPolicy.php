<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyPolicy extends Model
{
    //投保人表
    protected $table = 'warranty_policy';
//    public function policy_code_type()
//    {
//        return $this->belongsTo('App\Models\CodeType','code_type','id');
//    }

    //证件类型
//    public function policy_card_type()
//    {
//        return $this->hasOne('App\Models\CardType','number','card_type');
//    }
//
//    //职业
//    public function policy_occupation()
//    {
//        return $this->hasOne('App\Models\Occupation','number','occupation');
//    }

    //关联users表
    public function policy_users()
    {
        return $this->hasOne('App\Models\User','code','code');
    }



}
