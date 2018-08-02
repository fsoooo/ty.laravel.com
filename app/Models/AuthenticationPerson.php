<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthenticationPerson extends Model{

    protected $table = 'authentication_person';

    public $fillable = ['user_id', 'name', 'code', 'status', 'id_type'];

    //关联用户认证信息表
    public function true_user_info()
    {
        return $this->hasOne('App\Models\TrueUserInfo','user_id','user_id');
    }

    //关联users表
    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
}