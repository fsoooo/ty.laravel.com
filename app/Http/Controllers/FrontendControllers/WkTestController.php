<?php

/**
 * 悟空保接口
 */

namespace App\Http\Controllers\FrontendControllers;

use App\Helper\Issue;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
//use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\WarrantyRule;
class WkTestController extends BaseController
{
    protected $signHelp;

    public function __construct()
    {
        $this->signHelp = new RsaSignHelp();
    }

    /**
     * 算费接口
     */
    public function quote()
    {
        //业务参数封装
        $biz_content = [
            'productCode' => '149614236499831794',    //投保产品ID
            'insurePayWay' => '10',    //缴别[年]；分别为 10,15,20
            'durationPeriodType' => '0', //保期类型  0：终身【只有终身，只为0】
            'durationPeriodValue' => '0', //保期值  0：终身【只有终身，只为0】
            'insuredBirthday' => '2017-01-01',    //被保险人生日
            'insuredSex' => '1',    //被保险人性别，男：1；女：0
        ];
        //天眼接口参数封装
        $data = $this->signHelp->tySign($biz_content, ['api_from_uuid'=> 'Wk']);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/quote')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        echo "<pre>";
        var_dump($response);
    }

    /**
     * 投保
     */
    public function buyIns()
    {
        //业务参数封装
        $biz_content=[
            "productCode"=> "149559395942738681",   //产品编码
            "merchantOrderCode"=> rand(1000000,99999999),  //商户订单编码

            "policyInsuredList"=> [     //被保人List
                [
                    "holdInsRelation"=> "3",    //投保人与被保人关系
                    "insuredName"=> "徐成祥",  //被保人名称
                    "insuredPhone"=> "13521320175", //被保人电话
                    "insuredBirthday"=> "1999-01-01",   //被保人生日
                    "insuredSex"=> "1", //被保险人性别
                    "insuredIdType"=> "1",  //被保险人证件类型
                    "insuredIdNumber"=> "110101199901011291",   //被保险人证件号码
                    "insuredArea"=> "110000,110100,110101", //被保人所在地，格式“110000,110100,110101”，地区编码见附件
                    "insurePayWay"=> 10,    //缴别[年]；分别为 10,15,20
                    "coverageMultiples"=> 100,   //基础保额倍数 ，分别为 100、200、300、400、500例如10万保额传（100）（基础保额是1000元）目前只支持10万、20万、30万、50万
                    "durationPeriodType"=> 0,   //保期类型  0：终身【只有终身，只为0】
                    "durationPeriodValue"=> 0   //保期值0：终身【只有终身，只为0】
                ],
            ],
            "policyHolder"=> [  //投保信息
                "holderIdNumber"=> "341022199008240075",    //投保险人证件号码
                "holderArea"=> "110000,110100,110101",  //投保人所在地
                "holderOccupation"=> "0803027", //投保人职业编码
                "holderIdType"=> "1",   //投保险人证件类型
                "holderAddress"=> "北京市朝阳区南沙滩小区",    //投保险人详细地址
                "holderPhone"=> "18610217300",  //投保险人电话
                "holderName"=> "徐亚宁",    //投保险人姓名
                "holderEmail"=> "xuyanig_work@126.com" //投保险人邮箱
            ]
        ];
        //天眼接口参数封装
        $data = $this->signHelp->tySign($biz_content, ['api_from_uuid'=> 'Wk']);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/buy_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        echo "<pre>";
        var_dump($response);
    }

    /**
     * 核保
     */
    public function checkIns()
    {
        $biz_content = [
            "orderCode" => "WS62900916486846914560",    //外部订单编码
            "unionOrderCode" => "WS6290091648684691456",    //合并订单号
            "productCode" => "149559395942738681",  //产品编码
            "queryTime" => date('YmdHis')
        ];
        //天眼接口参数封装
        $data = $this->signHelp->tySign($biz_content, ['api_from_uuid'=> 'Wk']);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/check_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        echo "<pre>";
        var_dump($response);
    }

    /**
     * 支付
     */
    public function payIns()
    {
        $biz_content = [
            "unionOrderCode" => "WS6287623630327128064",    //合并订单号
            "hengqinBankCode" => "306",     //银行编码
            "bankCode" => "GDB",    //银行代号
            "bankCardNum" => "6214623721001364792"   //银行卡号
        ];
        //天眼接口参数封装
        $data = $this->signHelp->tySign($biz_content, ['api_from_uuid' => 'Wk']);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/pay_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        echo "<pre>";
        var_dump($response);
    }

    /**
     * 出单
     */
    public function issue()
    {
        $a = new Issue();
        $warranty_rule = WarrantyRule::where('union_order_code','WS6290798145987158016')
            ->with('warranty_product','warranty_rule_order')->first();
        $a->issue('Wk',$warranty_rule);



        $biz_content = [
            "orderCode" => "WS62904547213584711680",    //外部订单号
            "unionOrderCode" => "WS6290454721358471168",    //合并订单号
            "productCode" => "149559395942738681",    //产品码
        ];
        //天眼接口参数封装
        $data = $this->signHelp->tySign($biz_content, ['api_from_uuid' => 'Wk']);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/issue')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        echo "<pre>";
        var_dump($response);
    }

}