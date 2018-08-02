<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiInfo extends Model{

    protected $table = "ins_api_info";
    //产品 old
    public function product()
    {
        return $this->hasOne('App\Models\Product','ty_product_id','ty_product_id');
    }
}
