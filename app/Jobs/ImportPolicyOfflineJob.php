<?php

namespace App\Jobs;

use App\Models\Agent;
use App\Models\Cust;
use App\Models\CustRule;
use App\Models\Ditch;
use App\Models\DitchAgent;
use App\Models\MarketDitchRelation;
use App\Models\Order;
use App\Models\OrderBrokerage;
use App\Models\Product;
use App\Models\User;
use App\Models\Warranty;
use App\Models\WarrantyRule;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Cache;
use Exception;

class ImportPolicyOfflineJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $import;
    private $adminId;
    private $allowUpdate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($import,$adminId,$allowUpdate)
    {
        $this->import = $import;
        $this->adminId = $adminId;
        $this->allowUpdate = $allowUpdate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        Cache::increment('offlineJobSuccess' . $this->adminId);
//        Log::info('offlineJobSuccess: '.Cache::get('offlineJobSuccess' . $this->adminId));
//        return true;
//        Log::useFiles(storage_path('logs/importOffline_' . date('Ymd') . '.log'));
        Log::info('importContent : '.json_encode($this->import));
        $attribute = config('offline.policyOfflineAttribute');
        //要导入的数据
        $offlineData = array_combine(array_keys($attribute), $this->import);



        //保单10张照片保存为image的数组
        $offlineData['image'] = [
            $offlineData['image1'],
            $offlineData['image2'],
            $offlineData['image3'],
            $offlineData['image4'],
            $offlineData['image5'],
            $offlineData['image6'],
            $offlineData['image7'],
            $offlineData['image8'],
            $offlineData['image9'],
            $offlineData['image10'],
        ];
        $offlineData['image'] = array_filter($offlineData['image']);

        //判断是否已经有此保单编号的数据
        $warrantyList = Warranty::where('warranty_code', $offlineData['warranty_code'])->first();
        if (!is_null($warrantyList)) {//有此保单编号的数据
            $warrantyPolicy = WarrantyRule::where('warranty_id', $warrantyList['id'])->select('id', 'policy_cust_id', 'recognize_cust_id')->first();
            $warrantyRecognizeCustId = json_decode($warrantyPolicy['recognize_cust_id']);
            //投保人是企业
            $policyCompany = Cust::where('id', $warrantyPolicy['policy_cust_id'])->whereNotNull('company_name')->first();
            //被保人是个人
            $recognizePerson = Cust::where('id', $warrantyPolicy['recognize_cust_id'])->whereNull('company_name')->first();
            if (!is_null($policyCompany) && !is_null($recognizePerson)) {//增员
                $recognizeCustId = $this->addRecognize($offlineData);
                $warrantyRecognizeCustId[count($warrantyRecognizeCustId)] = $recognizeCustId;
                WarrantyRule::where('id', $warrantyPolicy['id'])->update(['recognize_cust_id' => json_encode($warrantyRecognizeCustId)]);
                \Cache::increment('offlineJobSuccess' . $this->adminId);
                Log::info('offlineJobSuccess 1 : '.\Cache::get('offlineJobSuccess' . $this->adminId));
            } else {//询问是否替换
                if ($this->allowUpdate == 0) {//已允许替换
                    //保存产品
                    $ty_product_id = $this->addProduct($offlineData);

                    //保存代理人
                    $agentAndDitch = $this->getAgent($offlineData);

                    //保存MarketDitchRelation表数据
                    $addResult = $this->addMarketDitchRelation($ty_product_id, $agentAndDitch, $offlineData);
                    if(!$addResult){
                        return true;
                    }

                    //投保人
                    $policyCustId = $this->addPolicy($offlineData);

                    //被保人
                    $recognizeCustId = $this->addRecognize($offlineData);

                    //更新订单表
                    $orderId = $this->updateOrder($offlineData, $agentAndDitch, $ty_product_id);

                    //更新order_brokerage表
                    $this->updateOrderBrokerage($orderId, $offlineData, $ty_product_id, $agentAndDitch);

                    //更新保单表
                    $this->updateWarranty($offlineData);

                    //更新warranty_rule表
                    $this->updateWarrantyRule($orderId, $offlineData, $agentAndDitch, $ty_product_id, $policyCustId, $recognizeCustId);
                    \Cache::increment('offlineJobSuccess' . $this->adminId);
                    Log::info('offlineJobSuccess 2 : '.\Cache::get('offlineJobSuccess' . $this->adminId));
                } else {
                    \Cache::increment('offlineJobUpdate' . $this->adminId);
                    Log::info('offlineJobUpdate 1 : '.\Cache::get('offlineJobUpdate' . $this->adminId));
                    return true;
                }
            }
        } else {//没有此保单
            //保存产品
            $ty_product_id = $this->addProduct($offlineData);

            //保存代理人
            $agentAndDitch = $this->getAgent($offlineData);

            //保存MarketDitchRelation表数据
            $addResult = $this->addMarketDitchRelation($ty_product_id, $agentAndDitch, $offlineData);
            if(!$addResult){
                return true;
            }

            //投保人
            $policyCustId = $this->addPolicy($offlineData);

            //被保人
            $recognizeCustId = $this->addRecognize($offlineData);

            //保存订单表
            $orderId = $this->addOrder($offlineData, $agentAndDitch, $ty_product_id);

            //保存order_brokerage表
            $this->addOrderBrokerage($orderId, $offlineData, $ty_product_id, $agentAndDitch);

            //保存保单表
            $warrantyId = $this->addWarranty($offlineData);

            //保存warranty_rule表
            $this->addWarrantyRule($orderId, $offlineData, $agentAndDitch, $warrantyId, $ty_product_id, $policyCustId, $recognizeCustId);
            \Cache::increment('offlineJobSuccess' . $this->adminId);
            Log::info('offlineJobSuccess 3 : '.\Cache::get('offlineJobSuccess' . $this->adminId));
        }
//        \Cache::increment('offlineJobSuccess' . $this->adminId);
//        Log::info('offlineJobSuccess: '.Cache::get('offlineJobSuccess' . $this->adminId));
    }



    /**
     * 更新warranty_rule表
     *
     * @param $orderId
     * @param $offlineData
     * @param $agentAndDitch
     * @param $ty_product_id
     * @param $policyCustId
     * @param $recognizeCustId
     */
    private function updateWarrantyRule($orderId,$offlineData,$agentAndDitch,$ty_product_id,$policyCustId,$recognizeCustId)
    {
        WarrantyRule::where('order_id',$orderId)->update([
            'premium'=>$offlineData['product_base_price'] * 100,
            'ditch_id'=>$agentAndDitch['ditchId'],
            'agent_id'=>$agentAndDitch['agentId'],
            'ty_product_id'=>$ty_product_id,
            'type'=>$offlineData['product_insure_type'] == '个险' ? 0 : 1,
            'policy_cust_id'=>$policyCustId,
            'recognize_cust_id'=>$recognizeCustId,
        ]);
    }

    /**
     * 保存warranty_rule表
     *
     * @param $orderId
     * @param $offlineData
     * @param $agentAndDitch
     * @param $warrantyId
     * @param $ty_product_id
     * @param $policyCustId
     * @param $recognizeCustId
     */
    private function addWarrantyRule($orderId,$offlineData,$agentAndDitch,$warrantyId,$ty_product_id,$policyCustId,$recognizeCustId)
    {
        $warrantyRule = new WarrantyRule();
        $warrantyRule->order_id = $orderId;
        $warrantyRule->union_order_code = $offlineData['warranty_code'] . date('Ymd', time());
        $warrantyRule->premium = $offlineData['product_base_price'] * 100;
        $warrantyRule->ditch_id = $agentAndDitch['ditchId'];
        $warrantyRule->warranty_id = $warrantyId;
        $warrantyRule->agent_id = $agentAndDitch['agentId'];
        $warrantyRule->ty_product_id = $ty_product_id;
        $warrantyRule->type = $offlineData['product_insure_type'] == '个险' ? 0 : 1;
        $warrantyRule->policy_cust_id = $policyCustId;
        $warrantyRule->recognize_cust_id = $recognizeCustId;
        $warrantyRule->save();
    }

    /**
     * 更新保单表
     *
     * @param $offlineData
     * @return mixed
     */
    private function updateWarranty($offlineData)
    {
        $warranty_status = 0;
        switch ($offlineData['warranty_status']) {
            case '待生效':
                $warranty_status = 0;
                break;
            case '保障中':
                $warranty_status = 1;
                break;
            case '失效':
                $warranty_status = 2;
                break;
            case '退保':
                $warranty_status = 3;
                break;
        }
        Warranty::where('warranty_code',$offlineData['warranty_code'])->update([
            'premium'=>$offlineData['product_base_price'] * 100,
            'warranty_image'=>json_encode($offlineData['image']),
            'start_time'=>$offlineData['warranty_start_time'],
            'end_time'=>$offlineData['warranty_end_time'],
            'status'=>$warranty_status,
        ]);
    }
    /**
     * 保存保单表
     *
     * @param $offlineData
     * @return mixed
     */
    private function addWarranty($offlineData)
    {
        $warranty_status = 0;
        switch ($offlineData['warranty_status']) {
            case '待生效':
                $warranty_status = 0;
                break;
            case '保障中':
                $warranty_status = 1;
                break;
            case '失效':
                $warranty_status = 2;
                break;
            case '退保':
                $warranty_status = 3;
                break;
        }

        //保存warranty表
        $warranty = new Warranty();
        $warranty->warranty_code = $offlineData['warranty_code'];
        $warranty->deal_type = 1;
        $warranty->premium = $offlineData['product_base_price'] * 100;
        $warranty->warranty_image = json_encode($offlineData['image']);
        $warranty->start_time = $offlineData['warranty_start_time'];
        $warranty->end_time = $offlineData['warranty_end_time'];
        $warranty->status = $warranty_status;
        $warranty->save();
        return $warranty->id;
    }

    /**
     * 更新order_brokerage表
     *
     * @param $orderId
     * @param $offlineData
     * @param $ty_product_id
     * @param $agentAndDitch
     */
    private function updateOrderBrokerage($orderId,$offlineData,$ty_product_id,$agentAndDitch)
    {
        OrderBrokerage::where('order_id',$orderId)->update([
            'order_pay'=>$offlineData['product_base_price'] * 100,
            'ty_product_id'=>$ty_product_id,
            'by_stages_way'=>is_null($offlineData['product_base_stages_way']) ? '0年' : $offlineData['product_base_stages_way'],
            'rate'=>$offlineData['market_agent_rate'],
            'user_earnings'=>$offlineData['product_base_price'] * $offlineData['market_agent_rate'],
            'agent_id'=>$agentAndDitch['agentId'],
            'ditch_id'=>$agentAndDitch['ditchId'],
        ]);
    }

    /**
     * 保存order_brokerage表
     *
     * @param $orderId
     * @param $offlineData
     * @param $ty_product_id
     * @param $agentAndDitch
     */
    private function addOrderBrokerage($orderId,$offlineData,$ty_product_id,$agentAndDitch)
    {
        $orderBrokerage = new OrderBrokerage();
        $orderBrokerage->order_id = $orderId;
        $orderBrokerage->order_pay = $offlineData['product_base_price'] * 100;
        $orderBrokerage->ty_product_id = $ty_product_id;
        $orderBrokerage->by_stages_way = is_null($offlineData['product_base_stages_way']) ? '0年' : $offlineData['product_base_stages_way'];
        $orderBrokerage->rate = $offlineData['market_agent_rate'];
        $orderBrokerage->user_earnings = $offlineData['product_base_price'] * $offlineData['market_agent_rate'];
        $orderBrokerage->agent_id = $agentAndDitch['agentId'];
        $orderBrokerage->ditch_id = $agentAndDitch['ditchId'];
        $orderBrokerage->save();
    }

    /**
     * 更新订单表
     *
     * @param $offlineData
     * @param $agentAndDitch
     * @param $ty_product_id
     * @return mixed
     */
    private function updateOrder($offlineData,$agentAndDitch,$ty_product_id)
    {
        $orderList = Order::where('order_code','like',$offlineData['warranty_code'].'%')->first();
        Order::where('id',$orderList['id'])->update([
            'agent_id'=>$agentAndDitch['agentId'],
            'ditch_id'=>$agentAndDitch['ditchId'],
            'ty_product_id'=>$ty_product_id,
            'by_stages_way'=>is_null($offlineData['product_base_stages_way']) ? '0年' : $offlineData['product_base_stages_way'],
            'pay_time'=>is_null($offlineData['order_pay_time'])?$offlineData['warranty_start_time']:$offlineData['order_pay_time'],
            'premium'=>$offlineData['product_base_price'] * 100,
            'start_time'=>$offlineData['warranty_start_time'],
            'end_time'=>$offlineData['warranty_end_time'],
        ]);
        return $orderList['id'];
    }
    /**
     * 保存订单表
     *
     * @param $offlineData
     * @param $agentAndDitch
     * @param $ty_product_id
     * @return mixed
     */
    private function addOrder($offlineData,$agentAndDitch,$ty_product_id)
    {
        //保存订单表
        $order = new Order();
        //生成订单号
        $order->order_code = $offlineData['warranty_code'] . date('Ymd', time());
        $order->is_settlement = 0;
        $order->agent_id = $agentAndDitch['agentId'];
        $order->ditch_id = $agentAndDitch['ditchId'];
        $order->ty_product_id = $ty_product_id;
        $order->by_stages_way = is_null($offlineData['product_base_stages_way']) ? '0年' : $offlineData['product_base_stages_way'];
        $order->pay_time = is_null($offlineData['order_pay_time'])?$offlineData['warranty_start_time']:$offlineData['order_pay_time'];
        $order->claim_type = 'offline';
        $order->deal_type = 1;
        $order->premium = $offlineData['product_base_price'] * 100;
        $order->start_time = $offlineData['warranty_start_time'];
        $order->end_time = $offlineData['warranty_end_time'];
        $order->save();
        return $order->id;
    }

    /**
     * 获取代理人
     *
     * @param $offlineData
     * @return array
     */
    private function getAgent($offlineData)
    {
        $agentList = Agent::where('phone', $offlineData['agent_phone'])->first();
        if (is_null($agentList)) {//不存在已有的代理人，则新增代理人
            //保存user表数据
            $userId = $this->addUser($offlineData);

            //保存agent表数据
            $agentId = $this->addAgent($offlineData,$userId);

            //保存渠道
            $ditchId = $this->addDitch($offlineData);

            //渠道和代理人关系表
            $this->addDitchAgent($ditchId,$agentId);
        } else {
            $agentId = $agentList['id'];
            $ditchId = Agent::with('ditches')
                ->where('id', $agentId)
                ->first();
            $ditchId = $ditchId->ditches[0]['id'];
        }
        return ['agentId'=>$agentId,'ditchId'=>$ditchId];
    }

    /**
     * 保存代理人
     *
     * @param $offlineData
     * @param $userId
     * @return mixed
     */
    private function addAgent($offlineData,$userId)
    {
        $agentModel = new Agent();
        $agentModel->job_number = $offlineData['agent_job_number'];
        $agentModel->user_id = $userId;
        $agentModel->email = $offlineData['agent_email'];
        $agentModel->phone = $offlineData['agent_phone'];
        $agentModel->pending_status = 0;
        $agentModel->certification_status = 0;
        $agentModel->work_status = 0;
        $agentModel->save();
        return $agentModel->id;
    }

    /**
     * 保存渠道和代理人关系表
     *
     * @param $ditchId
     * @param $agentId
     */
    private function addDitchAgent($ditchId,$agentId)
    {
        DitchAgent::insert([
            'ditch_id'=>$ditchId,
            'agent_id'=>$agentId,
            'status'=>'on',
        ]);
    }

    /**
     * 保存渠道
     *
     * @param $offlineData
     * @return mixed
     */
    private function addDitch($offlineData)
    {
        $ditchList = Ditch::where('name',$offlineData['ditch_name'])->first();
        if(is_null($ditchList)){
            //保存渠道
            $ditchModel = new Ditch();
            $ditchModel->name = $ditchModel->display_name = $offlineData['ditch_name'];
            $ditchModel->type = 'internal_group';
            $ditchModel->status = 'on';
            $ditchModel->save();
            $ditchId = $ditchModel->id;
        }else{
            $ditchId = $ditchList['id'];
        }
        return $ditchId;
    }

    /**
     * 保存用户
     *
     * @param $offlineData
     * @return mixed
     */
    private function addUser($offlineData)
    {
        $userList = User::where('phone',$offlineData['agent_phone'])->first();
        if(is_null($userList)){
            //保存user表数据
            $userModel = new User();
            $userModel->name = $userModel->real_name = $offlineData['agent_name'];
            $userModel->email = $offlineData['agent_email'];
            $userModel->phone = $offlineData['agent_phone'];
            $userModel->code = $offlineData['agent_code'];
            $userModel->password = bcrypt('123456');
            $userModel->save();
            $userId = $userModel->id;
        }else{
            $userId = $userList['id'];
        }
        return $userId;
    }

    /**
     * 保存产品
     *
     * @param $offlineData
     * @return int|mixed
     */
    private function addProduct($offlineData)
    {
        $productList = Product::where('product_name',$offlineData['product_name'])->first();
        if(is_null($productList)) {
            $min_ty_product_id = Product::where('ty_product_id', '<', 0)->select('ty_product_id')->min('ty_product_id');
            if (!is_null($min_ty_product_id)) {
                $ty_product_id = $min_ty_product_id - 1;
            } else {
                $ty_product_id = -1;
            }
            //保存product表
            $productModel = new Product();
            $productModel->ty_product_id = $ty_product_id;
            $productModel->product_name = $offlineData['product_name'];
            $productModel->insure_type = $offlineData['product_insure_type'] == '个险' ? 1 : 2;
            $productModel->base_price = $offlineData['product_base_price'] * 100;
            $productModel->base_stages_way = $offlineData['product_base_stages_way'];
            $productModel->base_ratio = $offlineData['market_agent_rate'];
            $productModel->company_name = $offlineData['product_company_name'];
            $productModel->product_category = $offlineData['product_category_name'];
            $productModel->json = json_encode(["category" => ["name" => $offlineData['product_category_name']]]);
            $productModel->personal = json_encode(["main_insure" => $offlineData['product_main_insure']]);
            $productModel->status = 1;
            $productModel->sale_status = 0;
            $productModel->save();
        }else{
            $ty_product_id = $productList['ty_product_id'];
        }
        return $ty_product_id;
    }

    /**
     * 保存投保人
     *
     * @param $offlineData
     * @return mixed
     */
    private function addPolicy($offlineData)
    {
        $custPolicyList = Cust::where('phone', $offlineData['policy_phone'])->first();
        if (is_null($custPolicyList)) {
            if (isset($offlineData['policy_company_name']) && !is_null($offlineData['policy_company_name'])) {//企业
                $policyCust = 2;
                $policyCustRule = 1;
            } else {//个人
                $policyCust = 1;
                $policyCustRule = 0;
            }
            //保存投保人
            $policyCustModel = new Cust();
            $policyCustModel->name = $offlineData['policy_name'];
            $policyCustModel->code = $offlineData['policy_code'];
            $policyCustModel->email = $offlineData['policy_email'];
            $policyCustModel->type = $policyCust;
            $policyCustModel->phone = $offlineData['policy_phone'];
            $policyCustModel->other = $offlineData['policy_other'];
            $policyCustModel->company_name = $offlineData['policy_company_name'];
            $policyCustModel->is_three_company = $offlineData['policy_is_three_company'] == '是' ? 0 : 1;
            $policyCustModel->organization_code = $offlineData['policy_organization_code'];
            $policyCustModel->license_code = $offlineData['policy_license_code'];
            $policyCustModel->tax_code = $offlineData['policy_is_three_company'] == '是' ? $offlineData['policy_all_code'] : $offlineData['policy_tax_code'];
            $policyCustModel->street_address = $offlineData['policy_street_address'];
            $policyCustModel->license_image = $offlineData['policy_license_image'];
            $policyCustModel->cust_from = '业管';
            $policyCustModel->save();
            $policyCustId = $policyCustModel->id;

            //保存客户关系
            $custRule = new CustRule();
            $custRule->code = $offlineData['policy_code'];
            $custRule->agent_id = 0;
            $custRule->type = $policyCustRule;
            $custRule->from_type = 1;
            $custRule->save();
        } else {
            $policyCustId = $custPolicyList['id'];
        }
        return $policyCustId;
    }
    /**
     * 添加被保人
     *
     * @param $offlineData
     * @return mixed
     */
    private function addRecognize($offlineData)
    {
        $custRecognizeList = Cust::where('phone', $offlineData['recognize_phone'])->first();
        if (is_null($custRecognizeList)) {
            if (isset($offlineData['recognize_company_name']) && !is_null($offlineData['recognize_company_name'])) {//企业
                $recognizeCust = 2;
                $recognizeCustRule = 1;
            } else {//个人
                $recognizeCust = 1;
                $recognizeCustRule = 0;
            }
            //保存投保人
            $recognizeCustModel = new Cust();
            $recognizeCustModel->name = $offlineData['recognize_name'];
            $recognizeCustModel->code = $offlineData['recognize_code'];
            $recognizeCustModel->email = $offlineData['recognize_email'];
            $recognizeCustModel->type = $recognizeCust;
            $recognizeCustModel->phone = $offlineData['recognize_phone'];
            $recognizeCustModel->other = $offlineData['recognize_other'];
            $recognizeCustModel->company_name = $offlineData['recognize_company_name'];
            $recognizeCustModel->is_three_company = $offlineData['recognize_is_three_company'] == '是' ? 0 : 1;
            $recognizeCustModel->organization_code = $offlineData['recognize_organization_code'];
            $recognizeCustModel->license_code = $offlineData['recognize_license_code'];
            $recognizeCustModel->tax_code = $offlineData['recognize_is_three_company'] == '是' ? $offlineData['recognize_all_code'] : $offlineData['recognize_tax_code'];
            $recognizeCustModel->street_address = $offlineData['recognize_street_address'];
            $recognizeCustModel->license_image = $offlineData['recognize_license_image'];
            $recognizeCustModel->cust_from = '业管';
            $recognizeCustModel->save();
            $recognizeCustId = $recognizeCustModel->id;

            //保存客户关系
            $custRule = new CustRule();
            $custRule->code = $offlineData['policy_code'];
            $custRule->agent_id = 0;
            $custRule->type = $recognizeCustRule;
            $custRule->from_type = 1;
            $custRule->save();
        } else {
            $recognizeCustId = $custRecognizeList['id'];
        }
        return $recognizeCustId;
    }

    /**
     * 保存MarketDitchRelation表数据
     *
     * @param $ty_product_id
     * @param $agentAndDitch
     * @param $offlineData
     * @return bool
     */
    private function addMarketDitchRelation($ty_product_id,$agentAndDitch,$offlineData)
    {
        //保存MarketDitchRelation表数据
        $marketDitchRelation = [
            'ty_product_id'=>$ty_product_id,
            'ditch_id'=>$agentAndDitch['ditchId'],
            'agent_id'=>$agentAndDitch['agentId'],
            'by_stages_way'=>is_null($offlineData['product_base_stages_way']) ? '0年' : $offlineData['product_base_stages_way'],
//                'rate'=>$offlineData['market_agent_rate'],
            'status'=>'on',
        ];
        $agentMarketDitchRelationList = MarketDitchRelation::where($marketDitchRelation)->select('rate')->first();
        $ditchMarketDitchRelationList = MarketDitchRelation::where($marketDitchRelation)->select('rate')->first();
        //代理人佣金比 必须 小于等于 渠道佣金比
        if(!is_null($ditchMarketDitchRelationList)){//渠道已存在
            //渠道佣金 小于等于 代理人佣金 时导入失败
            if($ditchMarketDitchRelationList['rate'] < $offlineData['market_agent_rate']){
                \Cache::increment('offlineJobFail' . $this->adminId);
                Log::info('offlineJobFail 1 : '.Cache::get('offlineJobFail' . $this->adminId));
                return false;
            }
        }elseif (is_null($ditchMarketDitchRelationList)
            && !is_null($offlineData['market_ditch_rate'])
            && ($offlineData['market_ditch_rate'] < $offlineData['market_agent_rate'])
        ){
            \Cache::increment('offlineJobFail' . $this->adminId);
            Log::info('offlineJobFail 1 : '.Cache::get('offlineJobFail' . $this->adminId));
            return false;
        }
//        if(!is_null($agentMarketDitchRelationList) && $agentMarketDitchRelationList['rate'] != $offlineData['market_agent_rate']){
//            //询问是否替换
//            if($this->allowUpdate == 0){//已允许替换
//                MarketDitchRelation::where($marketDitchRelation)->update(['rate'=>$offlineData['market_agent_rate']]);
//            }else{
//                \Cache::increment('offlineJobUpdate'.$this->adminId);
//                return true;
//            }
//
//        }else
        if (is_null($agentMarketDitchRelationList)){
            $marketDitchRelation['rate'] = $offlineData['market_agent_rate'];
            $agentMarketDitchRelation = new MarketDitchRelation();
            $agentMarketDitchRelation->fill($marketDitchRelation)->save();
        }

        $marketDitchRelation['agent_id'] = 0;
//        if(!is_null($ditchMarketDitchRelationList) && $ditchMarketDitchRelationList['rate'] != $offlineData['market_ditch_rate']){
//            //询问是否替换
//            if($this->allowUpdate == 0){//已允许替换
//                MarketDitchRelation::where($marketDitchRelation)->update(['rate'=>$offlineData['market_ditch_rate']]);
//            }else{
//                \Cache::increment('offlineJobUpdate'.$this->adminId);
//                return true;
//            }
//        }else
        if (is_null($ditchMarketDitchRelationList)) {
            $marketDitchRelation['rate'] = $offlineData['market_ditch_rate'];
            $ditchMarketDitchRelation = new MarketDitchRelation();
            $ditchMarketDitchRelation->fill($marketDitchRelation)->save();
        }
        return true;
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        \Cache::increment('offlineJobFail'.$this->adminId);
        Log::info('failCache: '.\Cache::get('offlineJobFail'.$this->adminId));
        Log::info('import exception :'.json_encode($exception));
    }
}
