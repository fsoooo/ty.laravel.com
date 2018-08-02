<?php
/**
 * Created by PhpStorm.
 * User: wangsl
 * Date: 2017/8/19
 * Time: 15:50
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    //渠道用户
    protected $table = 'user_contact';

    public function user()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }

}
