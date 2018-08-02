<?php

namespace App\Repositories;

use App\Models\MarketDitchRelation;

/**
 * 产品对应代理人佣金
 *
 * @category   Repository
 * @package    Api
 * @author     房玉婷 <fangyt@inschos.com>
 * @copyright  2017 (C) 北京天眼互联科技有限公司
 * @version    1.0.0
 * @since      v1.0
 */
class MarketDitchRelationRepository
{

    private $marketDitchRelation;

    public function __construct(MarketDitchRelation $marketDitchRelation)
    {
        $this->marketDitchRelation = $marketDitchRelation;
    }

    /**
     * 根据商品ID和代理人ID 计算佣金比
     *
     * @param $product_id
     * @param $ditch_id
     * @param $agent_id
     * @return array
     */
    public function getMyAgentBrokerage($product_id, $ditch_id, $agent_id)
    {
        $condition = array(
//            'type'=>'agent',
            'ty_product_id'=>$product_id,
            'ditch_id'=>$ditch_id,
            'agent_id'=>$agent_id,
            'status'=>'on',
        );
        $brokerage = MarketDitchRelation::where($condition)
            ->first();
        if(!$brokerage){
            //进行渠道统一查询
            $condition = array(
                'ty_product_id'=>$product_id,
                'ditch_id'=>$ditch_id,
                'agent_id'=>0,
            );
            $brokerage = MarketDitchRelation::where($condition)
                ->first();
            if(!$brokerage){//产品统一查询
                $condition = array(
//                    'type'=>'product',
                    'ty_product_id'=>$product_id,
                );
                $brokerage = MarketDitchRelation::where($condition)
                    ->first();
            }
        }
        if($brokerage){
            $earning = $brokerage->rate;
        }else{
            $earning = 0;
        }
//        $scaling = Scaling::where($condition)
//            ->first();
//        if(!$scaling){
//            //进行渠道统一查询
//            $condition = array(
//                'product_id'=>$product_id,
//                'ditch_id'=>$ditch_id,
//                'agent_id'=>0,
//            );
//            $scaling = Scaling::where($condition)
//                ->first();
//            if(!$scaling){//产品统一查询
//                $condition = array(
//                    'type'=>'product',
//                    'product_id'=>$product_id,
//                );
//                $scaling = Scaling::where($condition)
//                    ->first();
//            }
//        }
//        if($scaling){
//            $scaling = $scaling->rate;
//        }else{
//            $scaling = 0;
//        }
//        dd($earning);
        return array(
            'earning'=>$earning,  //佣金比
//            'scaling'=>$scaling   //折标系数
            'scaling'=>array()   //折标系数
        );
    }
}

