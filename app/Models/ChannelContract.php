<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelContract extends Model{

    protected $table = "channel_contract_info";
    //渠道用户信息
    public function channel_user_info()
    {
        return $this->hasOne('App\Models\ChannelPrepareInfo','channel_user_code', 'channel_user_code');
    }
    //订单信息
    public function order()
    {
        return $this->hasOne('App\Models\Order','union_order_code', 'union_order_code');
    }
}
