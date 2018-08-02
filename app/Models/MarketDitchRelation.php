<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketDitchRelation extends Model
{
    //佣金比率表
    protected $table = 'market_ditch_relation';

    protected $fillable = [
        'ty_product_id', 'ditch_id', 'agent_id', 'by_stages_way', 'rate', 'status'
    ];

//    public function market_product()
//    {
//        return $this->belongsTo('App\Models\Product','ty_product_id','id');
//    }
    
    public function ditch()
    {
        return $this->belongsTo('App\Models\Ditch', 'ditch_id', 'id');
    }
}
