<?php

namespace App\Http\Controllers\FrontendControllers\AgentControllers;

use App\Helper\RsaSignHelp;
use App\Models\Cust;
use App\Models\CustRule;
use App\Models\MarketDitchRelation;
use App\Models\Order;
use App\Models\OrderBrokerage;
use App\Models\Product;
use App\Models\Warranty;
use App\Models\WarrantyRule;
use App\Services\UploadImage;
use \Illuminate\Http\Request as Requests;
use App\Models\Agent;
use App\Repositories\MarketDitchRelationRepository;
use Request,DB;

class AgentSaleOfflineController extends AgentFuncController
{

    protected $_request;
    protected $_signHelp;
    private $cust;
    private $custRule;
    private $product;
    private $marketDitchRelationRepository;

    public function __construct(Request $request,Cust $cust, CustRule $custRule, Product $product, MarketDitchRelationRepository $marketDitchRelationRepository)
    {
        $this->_request = $request;
        $this->_signHelp = new RsaSignHelp();
        $this->cust = $cust;
        $this->custRule = $custRule;
        $this->product = $product;
        $this->marketDitchRelationRepository = $marketDitchRelationRepository;
    }

    /**
     * 添加客户
     */
    public function addCust(Requests $request)
    {
        $agent_id = $this->checkAgent();//检测是否是代理人
        $input = $request->all()['cust'];
        $input['cust_from'] = '代理人';
        $custRule = [];
        if(isset($input['all_code'])){
            $input['tax_code'] = $input['all_code'];
        }
        if(isset($input['company_name']) && !is_null($input['company_name'])){//企业
            $input['type'] = 2;
            $custRule['type'] = 1;
        }else{//个人
            $input['type'] = 1;
            $custRule['type'] = 0;
        }
        //是否已有添加的用户
        $custList = DB::table('cust')
            ->join('cust_rule','cust_rule.code','cust.code')
            ->where(function($query) use ($input){
                $query->where('cust.code',$input['code']);
                $query->orWhere('cust.phone',$input['phone']);
            })
            ->where('cust.type',$input['type'])
            ->where('cust_rule.agent_id',$agent_id)
            ->get();
        if(count($custList) != 0){
            return ['status'=>false,'msg'=>'已有此客户，请重新添加！'];
        }else{
            $this->cust->fill($input)->save();

            //保存客户关系
            $custRule['code'] = $input['code'];
            $custRule['agent_id'] = $agent_id;
            $custRule['from_type'] = 0;
            $this->custRule->fill($custRule)->save();

            return redirect('agent_sale/offline');
        }
    }

    /**
     * 把base64转换成image上传到服务器
     *
     * @param Requests $request
     * @return bool|string
     */
    public function uploadImage(Requests $request)
    {
        $size = file_get_contents($request->get('url'));
        if(strlen($size)/1024 > 5*1024){
            return ['status'=>false,'msg'=>'图片不能超过5M!'];
        }
        //删除旧图片数据
        if($request->get('old_val')){
            unlink(substr($request->get('old_val'),1));
        }
        $base64 = $request->get('url');
//        var_export($base64);exit;
        $path = 'frontend/offline/' . date("Ymd") .'/';

        $output_file = UploadImage::uploadImageWithBase($base64,$path);
        return '/upload/'.$path.$output_file;
    }

    /**
     * 添加产品
     */
    public function addProduct(Requests $request)
    {
        $agent_id = $this->checkAgent();//检测是否是代理人
        $input = $request->all()['cust'];
        if(isset($input['main_insure'])){//主险
            $input['personal'] = json_encode(['main_insure'=>$input['main_insure']]);
        }
        if(isset($input['classification'])){//产品分类
            $input['json'] = json_encode(['category'=>['name'=>$input['classification']]]);
            $input['product_category'] = $input['classification'];
        }
        if(isset($input['base_price']) && is_int($input['base_price'])){
            $input['base_price'] = $input['base_price']*100;
        }
        $input['status'] = 0;//下架
        $input['sale_status'] = 1;//停售
        $min_ty_product_id = $this->product->where('ty_product_id','<',0)->select('ty_product_id')->min('ty_product_id');
        if(!is_null($min_ty_product_id)){
            $input['ty_product_id'] = $min_ty_product_id-1;
        }else{
            $input['ty_product_id'] = -1;
        }
        $this->product->fill($input)->save();
        //保存MarketDitchRelation表数据
        $marketDitchRelation = new MarketDitchRelation();
        $marketDitchRelation->ty_product_id = $input['ty_product_id'];
        $marketDitchRelation->ditch_id = $this->getMyDitch($agent_id);
        $marketDitchRelation->agent_id = $agent_id;
        $marketDitchRelation->by_stages_way = is_null($input['base_stages_way']) ? '0年':$input['base_stages_way'];
        $marketDitchRelation->rate = -1;//佣金比等于-1 的时候表示 线下产品的状态为待审核
        $marketDitchRelation->status = 'on';
        $marketDitchRelation->save();
        return redirect('agent_sale/offline');
    }

    /**
     * 制作线下单
     */
    public function addOfflinePlan(Requests $request)
    {
        $agent_id = $this->checkAgent();//检测是否是代理人
        $option = 'agentOffline';
        $authentication = $this->isAuthentication($agent_id);
        $input = $request->all();

        /** 投保人列表 */
        $input['policy_type'] = isset($input['policy_type']) ? $input['policy_type'] : 1;
        $policyQuery = Cust::whereHas('cust_rule',function($query) use ($agent_id){
                $query->where('agent_id',$agent_id);
            })
//            ->join('cust_rule','cust_rule.code','cust.code')
//            ->where('agent_id',$agent_id)
            ->where('type',$input['policy_type']);
        if(isset($input['policy_search_type']) && !is_null($input['policy_search_type'])){
            $policySearchType = $input['policy_search_type'];
        }else{
            $policySearchType = NULL;
        }
        if(!is_null($policySearchType)){
            $where = [];
            if($input['policy_type'] == 1) {//个人
                switch ($policySearchType) {
                    case 1:
                        $where[] = ['name', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                    case 2:
                        $where[] = ['code', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                    case 3:
                        $where[] = ['phone', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                    case 4:
                        $where[] = ['email', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                }
            }else{//企业
                switch ($policySearchType) {
                    case 1:
                        $where[] = ['company_name', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                    case 2:
                    case 5:
                        $where[] = ['tax_code', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                    case 3:
                        $where[] = ['organization_code', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                    case 4:
                        $where[] = ['license_code', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                }
            }
            $policyQuery->where($where);
        }
        //投保人列表
        $policy = $policyQuery->orderBy('updated_at','DESC')->get();



        /** 被保人列表 */
        $input['recognize_type'] = isset($input['recognize_type']) ? $input['recognize_type'] : 1;
        //如果投保人是个人，则被保人不能是企业
        $input['recognize_type'] = $input['policy_type'] == 1 ? 1: $input['recognize_type'];
        $recognizeQuery = Cust::whereHas('cust_rule',function($query) use ($agent_id){
                $query->where('agent_id',$agent_id);
            })
            ->where('type',$input['recognize_type']);
        if(isset($input['recognize_search_type']) && !is_null($input['recognize_search_type'])){
            $recognizeSearchType = $input['recognize_search_type'];
        }else{
            $recognizeSearchType = NULL;
        }
        if(!is_null($recognizeSearchType)){
            $where = [];
            if ($input['recognize_type'] == 1) {
                switch ($recognizeSearchType) {
                    case 1:
                        $where[] = ['name', 'like', '%' . $input['recognize_content'] . '%'];
                        break;
                    case 2:
                        $where[] = ['code', 'like', '%' . $input['recognize_content'] . '%'];
                        break;
                    case 3:
                        $where[] = ['phone', 'like', '%' . $input['recognize_content'] . '%'];
                        break;
                    case 4:
                        $where[] = ['email', 'like', '%' . $input['recognize_content'] . '%'];
                        break;
                }
            }else{
                switch ($recognizeSearchType) {
                    case 1:
                        $where[] = ['company_name', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                    case 2:
                    case 5:
                        $where[] = ['tax_code', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                    case 3:
                        $where[] = ['organization_code', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                    case 4:
                        $where[] = ['license_code', 'like', '%' . $input['policy_content'] . '%'];
                        break;
                }
            }
            $recognizeQuery->where($where);
        }
        //被保人列表
        $recognize = $recognizeQuery->orderBy('updated_at','DESC')->get();

        $policyCount = count($policy);
        $recognizeCount = count($recognize);

        /** 产品列表 */
        $ditch_id = $this->getMyDitch($agent_id);//获取渠道

        if(isset($input['product_content']) && !is_null($input['product_content'])){
            $where = [];
            $marketQuery = MarketDitchRelation::where('agent_id', $agent_id)->where('status','on');
            switch($input['product_type']){
                case 1:
                    $where[] = ['product_name','like','%'.$input['product_content'].'%'];
                    break;
                case 2:
                    $where[] = ['company_name','like','%'.$input['product_content'].'%'];
                    break;
                case 3:
                    $where[] = ['product_category','like','%'.$input['product_content'].'%'];
                    break;
                case 4:
                    $marketQuery->where('rate',$input['product_content']);
//                    $where[] = ['product.base_ratio','like','%'.$input['product_content'].'%'];
                    break;
                case 5:
                    $where[] = ['personal','like','%'.$input['product_content'].'%'];
                    break;
            }
//            $product = $this->product->where($where)->where('status',1)->where('sale_status',0)->get();
            $market = $marketQuery->pluck('ty_product_id');

            $product_list = Product::whereIn('ty_product_id',$market)
                ->where($where)
                ->where('insure_type',$input['policy_type'])
                ->orderBy('updated_at','DESC')
                ->get();
        }else{
            $product_list = $this->getMyAgentProduct($agent_id, 1);//获取所有的产品列表
        }

        foreach($product_list as $k=>$v){
            //如果产品类型和投保人类型不符则删除
            if($v->insure_type != $input['policy_type']){
                unset($product_list[$k]);
            }
            //计算佣金比
            $v['rate'] = $this->marketDitchRelationRepository->getMyAgentBrokerage($v->ty_product_id,$ditch_id,$agent_id);
        }
        $product_count = count($product_list);
//        var_export(json_decode($product_list,true));exit;

        /** 代理人信息 */
        $jurisdiction = Agent::where('id',$agent_id)
            ->whereHas('user.user_authentication_person',function($q){
                $q->where('status',2);
            })
            ->first();
//        if($this->is_mobile()){
//            return view('frontend.agents.mobile.add_plan');
//        }

//        return [
//            'policy'=>$policy,
//            'recognize'=>$recognize,
//            'policyCount'=>$policyCount,
//            'recognizeCount'=>$recognizeCount,
//            'product_list'=>$product_list,
//            'product_count'=>$product_count,
//            'jurisdiction'=>$jurisdiction,
//            'option'=>$option,
//            'authentication'=>$authentication
//        ];
        return view('frontend.agents.agent_sale_offline.pop_offline',compact('input','policy','recognize','policyCount','recognizeCount','product_list','product_count','jurisdiction','option','authentication'));
    }

    /**
     * 线下单预览
     */
    public function getOfflinePreview(Requests $request)
    {
        $input = json_decode($request->get('preview'),true);

        $policy_id = $input['policy_id'];
        $recognize_id = $input['recognize_id'];
        $product_id = $input['product_id'];
        $image = $input['image'];
        //投保人信息
        $policy = $this->cust->find($policy_id);
        //被保人信息
        if(is_array($recognize_id)) {
            foreach ($recognize_id as $k=>$id) {
                $recognize[$k] = $this->cust->find($id);
                if ($policy_id === $recognize_id) {
                    $recognize[$k]['relation'] = '本人';
                } else {
                    $recognize[$k]['relation'] = '';
                }
            }
        }else{
            $recognize[0] = $this->cust->find($recognize_id);
            if ($policy_id === $recognize_id) {
                $recognize[0]['relation'] = '本人';
            } else {
                $recognize[0]['relation'] = '';
            }
        }
        //产品信息
        $product = $this->product->where('ty_product_id',$product_id)->first();

        $agent_id = $this->checkAgent();//检测是否是代理人
        $ditch_id = $this->getMyDitch($agent_id);//获取渠道
        //计算佣金比
        $product['rate'] = $this->marketDitchRelationRepository->getMyAgentBrokerage($product_id,$ditch_id,$agent_id);
        $warranty = json_encode($input);

        return view('frontend.agents.agent_sale_offline.offline_preview',compact('policy','recognize','product','image','agent_id','warranty'));
    }

    /**
     * 生成线下单提交
     */
    public function addOfflineSubmit(Requests $request)
    {
        $agent_id = $this->checkAgent();//检测是否是代理人
        $warranty_code = $request->get('warranty_code');
        $start_time = $request->get('start_time');
        $end_time = $request->get('end_time');
        $pay_time = $request->get('pay_time');
        $input = json_decode($request->get('warranty'),true);
        if(is_null($warranty_code) || is_null($start_time) || is_null($input)){
            return ['status'=>false,'msg'=>'缺少必要的参数'];
        }
//        return [$input,$warranty_code,$start_time,$end_time];
//        $input = ['policy_id'=>1,'recognize_id'=>[1,2],'product_id'=>1,'image'=>['/upload/frontend/offline/20171222/1513941779717.jpg','/upload/frontend/offline/20171222/1513944554686.jpg']];
        $product = $this->product->where('ty_product_id',$input['product_id'])->first();
        //保存订单表
        $order = new Order();
        //生成订单号
        $order->order_code = $warranty_code . date('Ymd',time());
        $order->is_settlement = 0;
        $order->agent_id = $agent_id;
        $order->ditch_id = $this->getMyDitch($agent_id);
        $order->ty_product_id = $input['product_id'];
        $order->by_stages_way = $product['base_stages_way'];
        $order->pay_time = is_null($pay_time)?$start_time:$pay_time;
        $order->claim_type = 'offline';
        $order->deal_type = 1;
        $order->premium = $product['base_price'];
        $order->start_time = $start_time;
        $order->end_time = $end_time;
        $order->save();

        //保存order_brokerage表
        $orderBrokerage = new OrderBrokerage();
        $orderBrokerage->order_id = $order->id;
        $orderBrokerage->order_pay = $product['base_price'];
        $orderBrokerage->ty_product_id = $input['product_id'];
        $orderBrokerage->by_stages_way = $product['base_stages_way'];
        $orderBrokerage->rate = -1;
        $orderBrokerage->user_earnings = 0;
        $orderBrokerage->agent_id = $agent_id;
        $orderBrokerage->ditch_id = $this->getMyDitch($agent_id);
        $orderBrokerage->save();

        //保存warranty表
        $warranty = new Warranty();
        $warranty->warranty_code = $warranty_code;
        $warranty->deal_type = 1;
        $warranty->premium = $product['base_price'];
        $warranty->warranty_image = json_encode($input['image']);
        $warranty->start_time = $start_time;
        $warranty->end_time = $end_time;
        $warranty->save();

        //保存warranty_rule表
        $warrantyRule = new WarrantyRule();
        $warrantyRule->order_id = $order->id;
        $warrantyRule->union_order_code = $warranty_code . date('Ymd',time());
        $warrantyRule->premium = $product['base_price'];
        $warrantyRule->ditch_id = $this->getMyDitch($agent_id);
        $warrantyRule->warranty_id = $warranty->id;
        $warrantyRule->agent_id = $agent_id;
        $warrantyRule->ty_product_id = $input['product_id'];
        $warrantyRule->type = $product['insure_type'] == 1 ? 0 : 1;
        $warrantyRule->policy_cust_id = $input['policy_id'];
        $warrantyRule->recognize_cust_id = json_encode($input['recognize_id']);
        $warrantyRule->save();

        return [
            'order_id'=>$order->id,
            'order_brokerage_id'=>$orderBrokerage->id,
            'warranty_id'=>$warranty->id,
            'warranty_rule_id'=>$warrantyRule->id,
        ];
    }

}
