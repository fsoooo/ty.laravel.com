<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    //规则表
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission','permission_role','role_id','permission_id');
    }
}
