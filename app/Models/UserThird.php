<?php
/**
 * Created by PhpStorm.
 * User: wangsl
 * Date: 2017/8/1
 * Time: 15:55
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserThird extends Model
{
    //三方登陆信息表
    protected $table = 'user_third';

    public function agent()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }
}
