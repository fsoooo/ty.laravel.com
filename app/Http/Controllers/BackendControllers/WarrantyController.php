<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/5/2
 * Time: 18:12
 */
namespace App\Http\Controllers\BackendControllers;
use App\Http\Controllers\BackendControllers;
use App\Models\Clause;
use App\Models\Company;
use App\Models\Product;
//use App\Models\RecognizeeGroup;
use App\Models\Warranty;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use App\Models\WarrantyRelation;
use App\Models\WarrantyRule;
use League\Flysystem\Exception;
use Request;
use App\Helper\Issue;
use Illuminate\Support\Facades\DB;
class WarrantyController extends BaseController{

 protected $issue;
public function __construct()
    {
      
        $this->issue = new Issue();
   
    }



    //封装一个方法，用来添加保单及相关信息
    public function addWarratnyFunc()
    {

    }




    //跳转到查看保单页面，默认为查看线上保单
    public function getWarranty($type)
    {
        $type = $type;
        $warranty = $this->getWarrantyByType($type);
        $warranty_list = $warranty->paginate(20);
        $count = count($warranty_list);
        return view('backend.warranty.warrantyList',compact('warranty_list','count','type'));
    }
    //封装一个方法，用来获得具体保单的信息
    public function getWarrantyDetail($union_order_code)
    {
		//判断是否已经出单
		$warranty_rule = WarrantyRule::where('union_order_code',$union_order_code)
			->with('warranty')->first();
			
		if(is_null($warranty_rule->warranty)){//进行出单
			 $warranty_id = $this->issue->issue($warranty_rule->warranty_product->api_from_uuid,$warranty_rule);
				if(!$warranty_id){
					 return back()->withErrors('错误');
				}
		}else{
            $warranty_id = $warranty_rule->warranty->id;
        }

        //获取保单信息，投保人信息，被保人信息
        $warranty_detail = $this->getWarrantyDetailFunc($warranty_id);
        if($warranty_detail){
            $policy_id = $warranty_detail->policy_id;
            $uuid = Product::where('id',$warranty_detail->product_id)->first()->api_from_uuid;
            //获取投保人的信息
            $policy_detail = $this->getPolicyMessage($uuid,$policy_id);
            //获取被保人的信息
            $order_id = $warranty_detail->order_id;
            $recognizee_detail = $this->getRecognizeeMessage($uuid,$order_id);
            return view('backend.warranty.detail',compact('warranty_detail','policy_detail','recognizee_detail'));
        }else{
            return back()->withErrors('错误');
        }
    }





    //跳转到分配保单页面
    public function distribution($warranty_id)
    {
        $agent_list = $this->getAgent();
        $count = count($agent_list);
        return view('backend.warranty.distribute',compact('agent_list','count'));
    }

    //封装一个方法，用来获取保单的所有信息
    public function getWarrantyDetailFunc($warranty_id)
    {
        $warranty_detail = Warranty::where('id',$warranty_id)
            ->with('warranty_rule')
            ->first();

        $warranty_detail = WarrantyRule::where('warranty_id',$warranty_id)
            ->with('warranty_product','warranty')
            ->first();
        if($warranty_detail && $warranty_detail->warranty){
            return $warranty_detail;
        }else{
            return false;
        }
    }

    //封装一个方法，用来获取一个保单的投保人信息
    public function getPolicyMessage($uuid,$policy_id)
    {
        //获取被保人的信息，同时获取证件类型
        $result = WarrantyPolicy::where('id',$policy_id)
            ->with(['policy_card_type'=>function($q)use($uuid){
                $q->where('api_from_uuid',$uuid);
            },'policy_occupation'=>function($q)use($uuid){
                $q->where('api_from_uuid',$uuid);
            }])->first();
        return $result;
    }
    //封装一个方法，用来获取被保人的信息
    public function getRecognizeeMessage($uuid,$order_id){
        $recognizee_detail = WarrantyRecognizee::where('order_id',$order_id)
            ->with(['recognizee_card_type'=>function($q)use($uuid){
                $q->where('api_from_uuid',$uuid);
            },'recognizee_occupation'=>function($q)use($uuid){
                $q->where('api_from_uuid',$uuid);
            },'recognizee_relation'=>function($q)use($uuid){
                $q->where('api_from_uuid',$uuid);
            }])->get();
        return $recognizee_detail;
    }



    //封装一个方法，用来获取不同类型的保单
    public function  getWarrantyByType($type)
    {
        if($type == 'all'){
            $warranty_list = WarrantyRule::with('warranty','warranty_product','warranty_rule_order')->orderBy('created_at','desc');
        }else if($type == 'offline'){
            //查找线下保单
            $warranty_list = WarrantyRule::with('warranty','warranty_product','warranty_rule_order')->whereHas('warranty_rule_order', function($w) {
				$w->where('deal_type',1);
			})->orderBy('created_at','desc');
        }else if($type == 'online'){
            //查找线上成交保单
            $warranty_list = WarrantyRule::with('warranty','warranty_product','warranty_rule_order')->whereHas('warranty_rule_order', function($w) {
				$w->where('deal_type',0);
			})->orderBy('created_at','desc');
        }else{
            return false;
        }
		
        return $warranty_list;
    }


    //封装一个方法，用来获取代理人和相关信息
    public function getAgent()
    {
        $result = DB::table('agents')
            ->join('users','agents.user_id','=','users.id')
            ->select('agents.*','users.real_name','users.code','users.name')
            ->get();
        return $result;
    }
}