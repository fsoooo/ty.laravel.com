<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\FrontendControllers\BaseController;
class TestController extends BaseController
{
    public function index()
    {
        $sign_help = new RsaSignHelp();
        //=======业务参数封装=======
        $biz_content = [
            //订单信息
            "orderinfo"=>[
                "order_no"=>'100095201706225',   //订单号
                "product_num" => 1, //产品数量
                "require_ticket" => 0,  //是否需要发票 为是需要增加寄送地址参数
            ],
            //产品基础信息
            "basicinfo"=>[
                "insure_begintime" => "2017-07-01 00:00:00", //保单生效日期
                "insure_endtime" => "2018-06-30 23:59:59",  //保单结束日期
                "product_code" => "P000000423", //产品编码
                "product_name" => "关爱加班狗保障计划（一万）", //产品名称
                "product_plan" => 'P000000423-1', //产品计划
                "total_premium" => 28.8, //费率
                "amount" => 10000,    //保额
                "company" => 4,   //承保公司
            ],
            //投保人信息
            "policyinfo"=>[
                "policy_name" => '徐亚宁', //投保人姓名
                "policy_mobile" => '18610217300', //投保人电话
                "policy_idtype" => 1, //证件类型 1 身份证
                "policy_idnum" => '341022199008240075', //证件号
                "policy_birthday" => '1990-08-24', //出生日期
                "policy_email" => 'xuyn@inschos.com', //邮箱地址
                "province" => '北京',
                "city" => '北京市',
                "address" => '东城区广渠门内福瑞苑大厦308',
                "relation_insure" => 0, //与被投保人关系
                "insured_count" => 1 //被保人数量
            ],
            //被保人信息
            "insureinfo"=>[
                [
                    "insure_name" => '徐亚宁', //被保人姓名
                    "insure_mobile" => '18610217300', //被保人电话
                    "insure_idtype" => 1,   //证件类型
                    "insure_idnum" => '341022199008240075', //证件号
                    "insure_birthday" => '1990-08-24', //出生日期
                    "insure_email" => 'xuyn@inschos.com', //邮箱地址
                    "is_social_security" => 1   //有无社保
                ]
            ],
            //附加信息
//            "additioninfo" => [
//                "addition_sign" => "8",   //非必须
//                "is_consent_inform" => "Y", //确认告知
//                "is_notice_confirm" => "Y", //同意告知
//            ]
        ];

        //=======天眼接口参数封装=======
        //业务数组 -> json->base64_url安全 -> 翻转后字符串
        $biz_content = strrev($sign_help->base64url_encode(json_encode($biz_content, JSON_UNESCAPED_UNICODE)));
        $data['account_id'] = '201706221136503001'; //id
        $data['timestamp'] = '1497409237';  //时间戳
        $data['biz_content'] = $biz_content;    //业务参数特殊字符串
        krsort($data);  //排序

        $data['sign'] = md5($sign_help->base64url_encode(json_encode($data)) . '6ffe0cb2e802a90bc1e31954be55f439'); //签名 todo 需要更安全

        //发送请求
        $response = Curl::to(config('curl_product.api_service_url') . '/check_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        echo "<pre>";
        var_dump($response);

    }


}