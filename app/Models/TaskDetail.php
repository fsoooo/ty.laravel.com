<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    protected $table = 'task_detail';

    public $fillable = ['year', 'month', 'money', 'ditch_id', 'agent_id'];

    public $timestamps = false;

    public function tasks()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
