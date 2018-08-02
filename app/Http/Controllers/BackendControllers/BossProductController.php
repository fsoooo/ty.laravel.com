<?php

namespace App\Http\Controllers\BackendControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BossProductController extends Controller
{
    //默认查看所有可售产品
    public function index($status)
    {
        switch($status){
            case 'all':
                $data=DB::table('product')->get();
                $count=count($data);
                $data=json_decode($data);
//        dd($data);
                return view('backend.boss.product.index',['product_list'=>$data,'count'=>$count,'type'=>$status]);
                break;
            case 'on_sale':
                $data=DB::table('product')->where('status','=','1')->get();
                $count=count($data);
                $data=json_decode($data);
                return view('backend.boss.product.index',['product_list'=>$data,'count'=>$count,'type'=>$status]);
                break;
            case 'not_sale':
                $data=DB::table('product')->where('status','=','0')->get();
                $count=count($data);
                $data=json_decode($data);
                return view('backend.boss.product.index',['product_list'=>$data,'count'=>$count,'type'=>$status]);
                break;
        }

    }

    //具体某个产品的详情
    public function getDetail($id){
//        dd($id);
        $data=DB::table('order')
            ->join('product','order.ty_product_id','=','product.ty_product_id')
            ->select('product.product_name','product.product_number','order.pay_time','order.claim_type','order.deal_type','order.premium','order.status')
            ->where('order.ty_product_id','=',$id)
            ->orderBy('order.pay_time','desc')
            ->get();
        $count=count($data);
        $data=json_decode($data);
//        dd($data);
        return view('backend.boss.product.getDetail',['count'=>$count,'product_list'=>$data]);
    }


}






















