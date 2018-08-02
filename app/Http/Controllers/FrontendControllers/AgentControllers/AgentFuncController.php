<?php

namespace App\Http\Controllers\FrontendControllers\AgentControllers;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\MarketDitchRelation;
use Illuminate\Support\Facades\DB;
use Request;
class AgentFuncController extends BaseController
{
    //


    //封装一个方法，用来判断当前产品自己是否可以进行销售
    public function isMyProduct($product_id){
        $agent_id = $this->checkAgent();
        if(!$agent_id){
            return false;
        }else{
//            $ditch = $this->getMyDitch($agent_id);
//            $ditch_array = $this->changeStdclassToArray($ditch->ditches,'id');
//            $result = MarketDitchRelation::where('product_id',$product_id)
//                ->where(function ($q){
//                    $q->where('brokerage_type','product')
//                        ->orwhere
//                })
//
//
//
//                ->where('agent_id',$agent_id)
//                ->count();
//            if($result){
                return true;
//            }else{
//                return false;
//            }
        }

    }

}
