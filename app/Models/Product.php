<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //产品表
    protected $table = 'product';
    protected $fillable = ['product_number','private_p_code','ty_product_id','api_from_uuid',
        'product_name','insure_type','base_price','base_stages_way','base_ratio','company_name',
        'company_email','product_category','cover','json','clauses','personal','status','sale_status',
        'delete_id'];
    //产品关联分类
    public function product_label()
    {
        return $this->belongsToMany('App\Models\Label','label_relevance','label_relevance','label_id');
    }
    public function label()
    {
        return $this->hasMany('App\Models\LabelRelevance','label_relevance','ty_product_id');
    }

    public function brokerages()
    {
        return $this->hasMany('App\Models\MarketDitchRelation', 'ty_product_id', 'ty_product_id');
    }

    public function companyBrokerage()
    {
        return $this->hasMany('App\Models\CompanyBrokerage', 'ty_product_id', 'ty_product_id');
    }

    //产品关联分类
    public function product_down_reason()
    {
        return $this->hasMany('App\Models\ProductDownReason','ty_product_id','ty_product_id');
    }

    public function apiInfo()
    {
        return $this->hasOne('App\Models\ApiInfo', 'ty_product_id', 'ty_product_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'ty_product_id', 'ty_product_id');
    }

    //陈延涛12.25添加关联产品佣金表
    public function market_ditch_relation()
    {
        return $this->hasMany('App\Models\MarketDitchRelation','ty_product_id','ty_product_id');
    }
}
