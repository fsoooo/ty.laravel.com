<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    //保单表
    protected $table = 'warranty';
    public function warranty_status()
    {
        return $this->belongsTo('App\Models\Status','status','id');
    }

    public function warranty_rule()
    {
        return $this->hasOne('App\Models\WarrantyRule','warranty_id','id');
    }

    public function warranty_order()
    {
        return $this->belongsToMany(Order::class, 'warranty_rule', 'warranty_id', 'order_id');
    }
}
