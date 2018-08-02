<?php
/**
 * Created by PhpStorm.
 * User: xyn
 * Date: 2017/12/4
 * Time: 16:35
 */

namespace App\Http\Controllers;


use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;

class TestCarInsController
{
    //车辆信息
    public function carInfo(RsaSignHelp $sign_help)
    {
        $biz_content = [
            'type' => 'frame',    //投保产品ID
            'car_number' => '3213232113',    //投保产品ID
        ];
        //天眼接口参数封装
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to('http://api.inschos.com/api/insurance_car/car_info')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        dd($response);
    }

    //条款信息
    public function clauseInfo(RsaSignHelp $sign_help)
    {
        $biz_content = [
            'msg' => 'getClauseInfo',    //请求信息描述
        ];
        //天眼接口参数封装
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to('http://www.p.com/api/insurance_car/clause_info')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        dd($response);
    }

    //下次投保时间
    public function nextInsTime(RsaSignHelp $sign_help)
    {
        $biz_content = [
            'responseNo' => '8f250190-31b9-4cf9-bea7-99f586ce31f1', //如果车架号发动机号是车辆信息接口返回的带星号的车架号发动机号或车架号发动机号为空，响应码就必传车辆信息接口中返回的
            'licenseNo' => '冀 A32679',    //投保产品ID
            'frameNo' => "",    //车架号
            'brandCode' => '16a65866-4fe2-49d3-b9f9-bd512c3274f9',  //品牌型号代码
            'engineNo'  => '',  //发动机号码
            'isTrans' => 0,    //是否过户
            'transDate' => '2016-02-19',    //如果是过户车，这个必传
            'cityCode' => 410700,    //国标码，到二级城市,410700
            'firstRegisterDate' => '2013-09-01' //初登日期
        ];
        //天眼接口参数封装
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to('http://www.p.com/api/insurance_car/next_ins_time')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        dd($response);
    }

    //省份查询
    public function provinces(RsaSignHelp $sign_help)
    {
        $biz_content = [
            'msg' => 'getProvinces',
        ];
        //天眼接口参数封装
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to('http://www.p.com/api/insurance_car/provinces')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        dd($response);
    }

    //城市查询
    public function cities(RsaSignHelp $sign_help)
    {
        $biz_content = [
            'provinceCode' => '123213',
        ];
        //天眼接口参数封装
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to('http://www.p.com/api/insurance_car/cities')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        dd($response);
    }

    //地区查询保险公司
    public function insurers(RsaSignHelp $sign_help)
    {
        $biz_content = [
            'provinceCode' => '3213232113',
        ];
        //天眼接口参数封装
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to('http://www.p.com/api/insurance_car/insurers')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        dd($response);
    }

    //精准报价
    public function quote(RsaSignHelp $sign_help)
    {
        $biz_content = [
            "thpBizID"=> "201606211527370721",
            "cityCode"=> "441900",
            "biBeginDate"=> "2016-07-21",
            "ciBeginDate"=> "2016-07-21",
            "insurerCode"=> "ASTP",
            "payType"=> "",
            "responseNo"=> "86b9958d-4d80-4031-a4fe-0b5c702b8112",
            "carInfo"=>[
                "licenseNo"=> "豫 JCC522",
                "frameNo"=> "",
                "brandCode"=> "6ce1a332-d37e-4846-85c8-a45b789721a7",
                "engineNo"=> "",
                "isTrans"=> "0",
                "transDate"=> "",
                "firstRegisterDate"=> "2015-09-17",
            ],
            "personInfo"=>[
                "ownerName"=> "张三",
                "ownerID"=> "220284198711124612",
                "ownerMobile"=> "13420060111",
                "insuredName"=> "张三",
                "insuredID"=> "220284198711124612",
                "insuredMobile"=> "13420060111",
                "applicantName"=> "张三",
                "applicantID"=> "220284198711124612",
                "applicantMobile"=> "13420060111"
            ],
            "coverageList"=>[
                    [
                        "coverageCode"=> "A",
                        "coverageName"=> "机动车损失保险",
                        "insuredAmount"=> "Y",
                        "flag"=> null
                    ],
                    [
                        "coverageCode"=> "B",
                        "coverageName"=> "商业第三者责任险",
                        "insuredAmount"=> "300000",
                        "flag"=> null
                    ],
                    [
                        "coverageCode"=> "MA",
                        "coverageName"=> "机动车损失保险不计免赔",
                        "insuredAmount"=> "Y",
                        "flag"=> null
                    ],
                    [
                        "coverageCode"=> "D3",
                        "coverageName"=> "车上人员责任保险(驾驶员)",
                        "insuredAmount"=> "20000",
                        "flag"=> null
                    ],
                    [
                        "coverageCode"=> "MD3",
                        "coverageName"=> "车上人员责任保险不计免赔(驾驶员)",
                        "insuredAmount"=> "Y",
                        "flag"=> null
                    ],
                    [
                        "coverageCode"=> "D4",
                        "coverageName"=> "车上人员责任保险(乘客)",
                        "insuredAmount"=> "10000",
                        "flag"=> null
                    ],
                    [
                        "coverageCode"=> "D4",
                        "coverageName"=> "车上人员责任保险(乘客)",
                        "insuredAmount"=> "10000",
                        "flag"=> null
                    ],
                    [
                        "coverageCode"=> "FORCEPREMIUM",
                        "coverageName"=> "交强险",
                        "insuredAmount"=> "Y",
                        "flag"=> null
                    ]
            ]

        ];
        //天眼接口参数封装
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to('http://www.p.com/api/insurance_car/quote')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        print_r($response);
    }

    //投保
    public function buyIns(RsaSignHelp $sign_help)
    {
        $biz_content = [
            "channelCode"=> "AS_INSURE",
            "insurerCode"=> "ASTP",
            "bizID"=> "30282536",
            "addresseeName"=> "张三",
            "addresseeMobile"=> "15810142111",
            "addresseeDetails"=> " 广 东 ",
            "addresseeCounty"=> "441803",
            "addresseeCity"=> "441800",
            "addresseeProvince"=> "440000",
            "policyEmail"=> "Gfjhb@qq.com",
            "verificationCode"=> "",
            "refereeMobile"=> ""
        ];
        //天眼接口参数封装
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to('http://www.p.com/api/insurance_car/buy_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        print_r($response);
    }

}