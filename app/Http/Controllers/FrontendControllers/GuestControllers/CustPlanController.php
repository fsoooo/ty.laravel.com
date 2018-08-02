<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/10/26
 * Time: 17:12
 */
namespace App\Http\Controllers\FrontendControllers\GuestControllers;
use App\Helper\RsaSignHelp;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;

class CustPlanController extends BaseController{

    protected $_request;
    protected $_signHelp;

    public function __construct(Request $request)
    {
        $this->_request = $request;
        $this->_signHelp = new RsaSignHelp();
    }

    /**
     * 客户打开计划书
     */
    public function custPlan($id)
    {
        $plan_lists_id = $id;
        $option = 'plan';
        //计划书详情
        $detail = DB::table('plan_lists')
            ->join('users','plan_lists.plan_recognizee_id','users.id')
            ->where('plan_lists.id',$id)
            ->select('users.*','plan_lists.ty_product_id','plan_lists.selling','plan_lists.url','plan_lists.name as plan_name')
            ->first();
        //产品信息
        $product = DB::table('product')
            ->where('ty_product_id',$detail->ty_product_id)
            ->first();
        $product->json = json_decode($product->json,true);
        $detail->product_name = $product->product_name;//产品名称
        $detail->premium = $this->getProductPremium($detail->ty_product_id);//产品保费
        //获取产品的条款
        $biz_content = [
            'ty_product_id' => $detail->ty_product_id,    //投保产品ID
        ];
        //天眼接口参数封装
        $data = $this->_signHelp->tySign($biz_content);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/getapioption')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(120)
            ->post();
        $return_data = json_decode($response->content, true);
        $detail->protect_items = $return_data['option']['protect_items'];
        $detail->age = date('Y',time())-substr($detail->code,6,4);
        //代理人信息
        $agent_detail = DB::table('agents')
            ->join('users','agents.user_id','users.id')
            ->select('users.*')
            ->first();
//        dd($agent_detail);
        //代理人标签
        $lables = Label::where([
            ['label_belong','agent'],
            ['parent_id','<>',0]
        ])->get();
//        dd($lables);
        if($this->is_mobile()){
            return view('frontend.agents.mobile.plan_client',compact('detail','agent_detail','option','plan_lists_id','product'));
        }
        return view('frontend.agents.agent_plan.cust_plan',compact('lables','detail','agent_detail','option','plan_lists_id','product'));
    }

    /**
     * 获取基础费率
     *
     */
    public function getProductPremium($id)
    {
        $biz_content = [
            'ty_product_id' => $id,    //投保产品ID
        ];
        //        dd($biz_content);
        //天眼接口参数封装
        $data = $this->_signHelp->tySign($biz_content);
        //        dd($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/getapioption')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(120)
            ->post();
        $return_data = json_decode($response->content, true);
//        dd($return_data);
        return $return_data['option']['price'];
    }

    /**
     * 用户评价
     */
    public function evaluateSubmit(Request $request)
    {

    }
}