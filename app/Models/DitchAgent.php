<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DitchAgent extends Model
{
    //
    protected $table='ditch_agent';

    public function agent()
    {
        return $this->hasOne('App\Models\Agent','id','agent_id');
    }
    public function ditch()
    {
        return $this->hasOne('App\Models\Ditch','id','ditch_id');
    }

    public function task(){
        return $this->hasMany('App\Models\TaskDetail','agent_id','agent_id');
    }
}
