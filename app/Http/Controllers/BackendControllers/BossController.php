<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BossController extends Controller
{




    //封装一个方法，用来获取产品的详情
    public function getProductDetail($product_id)
    {
        $product_detail = Product::where('id',$product_id)
            ->with('product_label')
            ->first();
        return $product_detail;
    }
}
