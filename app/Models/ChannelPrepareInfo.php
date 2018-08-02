<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannelPrepareInfo extends Model{

    protected $table = "channel_prepare_info";
    //关联渠道操作表
    public function channelOperateRes()
    {
        return $this->hasMany('App\Models\ChannelOperate','channel_user_code','channel_user_code');
    }
}
