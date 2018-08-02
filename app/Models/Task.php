<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //任务表
    protected $table = 'task';

    public $timestamps = false;

    protected $fillable = [
        'type', 'money', 'desc', 'created_at'
    ];

    public function task_condition()
    {
        return $this->hasMany('App\Models\TaskCondition','task_id','id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'task_product', 'task_id', 'product_id');
    }

    public function ditches()
    {
        return $this->belongsToMany(Ditch::class, 'task_ditch', 'task_id', 'ditch_id');
    }

    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'task_agent', 'task_id', 'agent_id');
    }
}
