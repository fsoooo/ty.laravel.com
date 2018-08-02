<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    //用户表
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getMyMessage()
    {
        return $this->hasMany('App\Models\MessageRule','rid','id');
    }

    //真实信息
    public function trueUserInfo()
    {
        return $this->hasOne('App\Models\TrueUserInfo','user_id', 'id');
    }

    //代理人
    public function agent()
    {
        return $this->hasOne('App\Models\Agent', 'user_id', 'id');
    }
    //三方登录
    public function UserThird()
    {
        return $this->hasOne('App\Models\UserThird', 'user_id', 'id');
    }
    //常用联系人
    public function userContacts()
    {
        return $this->hasMany('App\Models\UserContact','user_id','id');
    }

    public function order()
    {
        return $this->hasMany('App\Models\Order','user_id','id');
    }
    
    //关联个人认证表
    public function user_authentication_person()
    {
        return $this->hasOne('App\Models\AuthenticationPerson','user_id','id');
    }
    
    //关联客户分配表
    public function custRule()
    {
        return $this->hasOne('App\Models\CustRule','user_id','id');
    }

    //关联公司认证true_firm_info表
    public function trueFirmInfo()
    {
        return $this->hasOne('App\Models\TrueFirmInfo','user_id','id');
    }

    //关联公司认证表
    public function authentication()
    {
        return $this->hasOne('App\Models\Authentication','user_id','id');
    }
}
