<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDownReason extends Model
{
    //产品 标签 中间表
    protected $table = 'product_down_reason';
    //关联产品
    public function warranty_product()
    {
        return $this->hasOne('App\Models\Product','ty_product_id','ty_product_id ');
    }
}
