<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentAccountRecord extends Model
{
    //
    protected $table = 'agent_account_record';



    //提现记录关联客户
    public function agent_account_record_user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
