<?php
/**
 * Created by PhpStorm.
 * User: wangsl
 * Date: 2017/8/1
 * Time: 15:55
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserChannel extends Model
{
    //渠道用户
    protected $table = 'user_channel';

    public function channel()
    {
        return $this->hasOne('App\Models\Channel', 'only_id', 'channel_only_id');
    }
}
