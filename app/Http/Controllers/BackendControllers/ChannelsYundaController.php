<?php

namespace App\Http\Controllers\BackendControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Image, Schema,DB;
use App\Models\Channel;
use App\Models\ChannelInsureInfo;
use App\Models\User;
use App\Models\Product;
use App\Models\Ditch;
use App\Models\Agent;
use App\Models\DitchAgent;
use App\Models\MarketDitchRelation;

class ChannelsYundaController extends Controller
{

   public function brokerage(){
       $product = Product::where('private_p_code',config('channel_product_info.yunda.private_p_code'))->where('ty_product_id','>=',0)->first(); //产品信息
       $ditch = Ditch::where('name', 'like', '%'. config('channel_product_info.yunda.channel_name') .'%')->first();  //渠道列表
       $ty_product_id = $product['ty_product_id'];
       $ditch_id  = $ditch['id'];
           $res = Product::where('ty_product_id', $ty_product_id);
           $res = $res->with(['brokerages'=>function($q) use ($ditch_id) {
               $q->where(['ditch_id'=> $ditch_id, 'agent_id'=> 0, 'status'=>'on']);
           },
               'brokerages.ditch'])->paginate(config('list_num.backend.brokerage_ditch'));
//           dump($res);
       return view('backend_v2.channels.yunda.brokerage', compact('product', 'ditch', 'res'));
   }
}
