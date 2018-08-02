<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Behaviour extends Model
{
    //工作流行为规范表
    protected $table = 'behaviour';
    public function behaviour_node(){
        return $this->belongsTo('App\Models\Node','none_id','id');
    }
}
