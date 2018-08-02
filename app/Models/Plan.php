<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //计划书
    protected $table = 'plan';

    public function product()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
