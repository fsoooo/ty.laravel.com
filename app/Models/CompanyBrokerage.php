<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyBrokerage extends Model
{
    //
    protected $table = 'company_brokerage';
    //公司佣金和订单关联
    public function company_brokerage_order()
    {
        return $this->belongsTo('App\Models\Order','order_id','id');
    }
    //公司佣金和保单关联
    public function company_brokerage_warranty()
    {
        return $this->hasOne('App\Models\Warranty','id','warranty_id');
    }

    //公司佣金和产品关联
    public function product(){
        return $this->hasOne('App\Models\Product','ty_product_id','ty_product_id');
    }


}
