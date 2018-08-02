<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelOperate extends Model{

    protected $table = "channel_operate";
    //渠道用户信息
    public function channel_user_info()
    {
        return $this->hasOne('App\Models\ChannelPrepareInfo','channel_user_code', 'channel_user_code');
    }
    //订单
    public function order()
    {
        return $this->hasOne('App\Models\Order','id', 'order_id');
    }
    //保单
    public function warranty()
    {
        return $this->hasOne('App\Models\WarrantyRule','union_order_code', 'proposal_num');
    }
}
