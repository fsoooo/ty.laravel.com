<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    //标签表
    public function products(){
        return $this->belongsToMany('App\Models\Product', 'label_relevance', 'label_id', 'label_relevance');
    }
}
