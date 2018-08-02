<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabelRelevance extends Model
{
    //标签关联表
    protected $table = 'label_relevance';
    public function products(){
        return $this->belongsToMany('App\Models\Product', 'label_product', 'label_id', 'product_id');
    }
    public function labels()
    {
        return $this->belongsToMany('App\Models\Label','label_relevance','label_relevance','label_id');
    }
}
