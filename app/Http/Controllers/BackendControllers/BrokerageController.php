<?php
/**
 * Created by PhpStorm.
 * User: xyn
 * Date: 2017/9/26
 * Time: 19:27
 */

namespace App\Http\Controllers\BackendControllers;

use App\Models\Product;
use App\Models\Ditch;
use App\Models\Agent;
use App\Models\DitchAgent;
use App\Models\MarketDitchRelation;

class BrokerageController extends BaseController
{
    /**
     * 佣金设置列表
     * @return mixed
     */
    public function index()
    {
//        $products = Product::get(); //产品列表
        //过滤线下产品
        $products = Product::where('ty_product_id','>=',0)->where('status','1')->get(); //产品列表
        $ditches = Ditch::where('status', 'on')->get();  //渠道列表
        $input = $this->request->all();
        $ty_product_id = isset($input['ty_product_id']) ? $input['ty_product_id'] : 0;
        $input['ditch_id'] = $ditch_id = isset($input['ditch_id']) ? $input['ditch_id'] : (count($ditches) ? $ditches[0]->id : 0);

        //产品搜索
        if($ty_product_id){
            $res = Product::where('ty_product_id', $ty_product_id)->where('status','1');
                $res = $res->with(['brokerages'=>function($q) use ($ditch_id) {
                    $q->where(['ditch_id'=> $ditch_id, 'agent_id'=> 0, 'status'=>'on']);
                },
                'brokerages.ditch'])->paginate(config('list_num.backend.brokerage_ditch'));
        //全部产品
        } else {
            $res = new Product();
                $res = $res->with(['brokerages'=>function($q) use ($ditch_id) {
                    $q->where(['ditch_id'=> $ditch_id, 'agent_id'=> 0, 'status'=>'on']);
                },
                'brokerages.ditch'])
                    ->where('ty_product_id','>=',0)
                    ->where('status','1')
                    ->paginate(config('list_num.backend.brokerage_ditch'));//过滤线下产品
        }
        return view('backend_v2.brokerage.index', compact('products', 'ditches', 'input', 'res','ty_product_id','ditch_id'));
    }

    public function agentBrokerage()
    {
//        $products = Product::get(); //产品列表
        $products = Product::where('ty_product_id','>=',0)->get(); //产品列表
        $ditches = Ditch::where('status', 'on')->get();  //渠道列表
        $input = $this->request->all();
        $ty_product_id = isset($input['ty_product_id']) ? $input['ty_product_id'] : 0;
        $input['ditch_id'] = $ditch_id = isset($input['ditch_id']) ? $input['ditch_id'] : (count($ditches) ? $ditches[0]->id : 0);

        $agents = Agent::whereHas('ditches', function($q) use ($input){
                $q->where('ditch_id', $input['ditch_id']);
            })->where(['pending_status'=>1,'certification_status'=>1,'work_status'=>1])
            ->with('user')
            ->get();

        $input['agent_id'] = $agent_id = isset($input['agent_id']) ? $input['agent_id'] : (count($agents) ? $agents[0]->id : 0);
        if($ty_product_id){
            $res = Product::where('ty_product_id', $ty_product_id);
            $res = $res->with(['brokerages'=>function($q) use ($ditch_id, $agent_id) {
                $q->where(['ditch_id'=> $ditch_id, 'agent_id'=> $agent_id, 'status'=>'on']);
            },
                'brokerages.ditch'])->paginate(config('list_num.backend.brokerage_agent'));
            //全部产品
        } else {
            $res = new Product();
            $res = $res->with(['brokerages'=>function($q) use ($ditch_id, $agent_id) {
                $q->where(['ditch_id'=> $ditch_id, 'agent_id'=> $agent_id, 'status'=>'on']);
            },
                'brokerages.ditch'])
                ->where('ty_product_id','>=',0)
                ->paginate(config('list_num.backend.brokerage_agent'));
        }
        return view('backend_v2.brokerage.agent_brokerage', compact('products', 'ditches', 'agents', 'input', 'res'));
    }

    /**
     * 佣金设置提交
     * @return mixed
     */
    public function setBrokeragePost()
    {
        $input = $this->request->all();
        $ty_product_id = $input['ty_product_id'][0];
        $ditch_id = $input['ditch_id'][0];

        $product = Product::where('ty_product_id', $ty_product_id)->first();
        $p_json = json_decode($product->json, true);
        $p_brokerage = $p_json['brokerage'];

        $agent = DitchAgent::where(['ditch_id'=>$ditch_id,'status'=>'on']);   //渠道下所有代理人
        //设置单个代理人
        if(isset($input['agent_id']))
            $agent = $agent->where('agent_id', $input['agent_id'][0]);
        $agent = $agent->pluck('agent_id');

        $brokerage_ditch = array();
        $brokerage_agent = array();
        //渠道
        foreach($input['brokerage'] as $k => $v){
            if(!$input['ditch_id'][$k] || !$input['by_stages_way'][$k] || !$input['ty_product_id'][$k])
                return redirect(url()->previous())->withErrors('请输入全部比例');
            foreach($p_brokerage as $p_k => $p_v){
                if(((int)$input['by_stages_way'][$k] == $p_v['by_stages_way']) && ($v > $p_v['ratio_for_agency']))
                    return redirect(url()->previous())->withErrors('渠道/代理人比例 不得大于获益佣金比例');
            }
            $brokerage_ditch[$k]['rate'] = $v;
            $brokerage_ditch[$k]['ty_product_id'] = $ty_product_id;
            $brokerage_ditch[$k]['ditch_id'] = $ditch_id;
            $brokerage_ditch[$k]['agent_id'] = 0;
            $brokerage_ditch[$k]['by_stages_way'] = $input['by_stages_way'][$k];
            $brokerage_ditch[$k]['created_at'] = $brokerage[$k]['updated_at']= date('Y-m-d H:i:s');

        }
        //代理人
        foreach($agent as $ak => $av){
            $a = count($brokerage);
            foreach($input['brokerage'] as $qk => $qv){
                 $i = $a + $qk;
                $brokerage_agent[$i]['rate'] = $qv;
                $brokerage_agent[$i]['ty_product_id'] = $ty_product_id;
                $brokerage_agent[$i]['ditch_id'] = $ditch_id;
                $brokerage_agent[$i]['agent_id'] = $av;
                $brokerage_agent[$i]['by_stages_way'] = $input['by_stages_way'][$qk];
                $brokerage_agent[$i]['created_at'] = $brokerage[$i]['updated_at']= date('Y-m-d H:i:s');
            }
        }

        //代理人佣金设置
        if(isset($input['agent_id'])){
            $ditch_market = MarketDitchRelation::where(['ditch_id'=>$ditch_id, 'ty_product_id'=>$ty_product_id, 'status'=>'on', 'agent_id'=>0])->get();
            //是否设置过渠道佣金
            if(count($ditch_market)< 1)
                return redirect(url()->previous())->withErrors('请先前往设置渠道佣金');
            //代理人佣金是否大于渠道佣金
            foreach($brokerage_agent as $k => $v){
                foreach($ditch_market as $dk => $dv){
                    if(($dv->by_stages_way == $v['by_stages_way']) && ($dv->rate < $v['rate'])){
                        return redirect(url()->previous())->withErrors('代理人佣金不得大于其所在渠道');
                    }
                }
            }
            MarketDitchRelation::where(['ditch_id'=>$ditch_id, 'ty_product_id'=>$ty_product_id, 'agent_id'=> $input['agent_id'][0]])->update(['status'=>'off']);
            MarketDitchRelation::insert($brokerage_agent);
        } else {
            $merge = array_merge($brokerage_ditch, $brokerage_agent);
            MarketDitchRelation::where(['ditch_id'=>$ditch_id, 'ty_product_id'=>$ty_product_id])->update(['status'=>'off']);
            MarketDitchRelation::insert($merge);
        }
        return redirect(url()->previous())->with('status', '成功修改佣金设置!');
    }
}