<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/26
 * Time: 15:36
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ClaimRule extends Model{
    protected $table="claim_rule";

    //一对多关联查询，查找理赔记录
    public function get_claim()
    {
        return $this->hasOne('App\Models\Claim','id','claim_id');
    }

    //关联用户
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
    //关联订单
    public function Order()
    {
        return $this->hasOne('App\Models\Order','id','order_id');
    }


}
