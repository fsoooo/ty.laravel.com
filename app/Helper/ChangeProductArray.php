<?php
namespace App\Helper;

class ChangeProductArray{
    /**
     * 用来修改数组变成对应的参数
     * @param $data string
     * @param $key string
     * @param $key_type string
     * @return mixed
     */
    public function changeArray($abbreviation,$biz_content)
    {
        //悟空保
        if($abbreviation == 'Wk'){
            $result_content['productCode'] = $biz_content['product_code'];  //产品编码
            $result_content['merchantOrderCode'] = rand(1000000,99999999);  //中介订单编码
            $result_content['policyInsuredList'] = array();
            foreach($biz_content['regnizee_info'] as $value)
            {
                $a = array();
                $a['holdInsRelation'] = $value['relation']; //投保人和被保人的关系
                $a['insuredName'] = $value['name']; //被保人姓名
                $a['insuredPhone'] = $value['phone']; //被保人电话
                $a['insuredBirthday'] = $value['birthday']; //被保人生日   暂无，标注
                $a['insuredSex'] = $value['sex'];   //被保人性别   暂无，标注
                $a['insuredIdType'] = $value['card_type'];   //被保人证件类型
                $a['insuredIdNumber'] = $value['code'];   //被保人证件号码
                $a['insuredArea'] = "110000,110100,110101";   //被保人所在地，   暂无，写死
                $a['insurePayWay'] = 10;   //缴别[年]；分别为 10,15,20   暂无，写死
                $a['coverageMultiples'] = 100;   //基础保额倍数 ，分别为 100、200、300、400、500例如10万保额传（100）（基础保额是1000元）目前只支持10万、20万、30万、50万   暂无，写死
                $a['durationPeriodType'] = 0;   //保期类型  0：终身【只有终身，只为0】
                $a["durationPeriodValue"] = 0;   //保期值0：终身【只有终身，只为0】
                array_push($result_content['policyInsuredList'],$a);
            }
            $result_content['policyHolder'] = array();
            $result_content['policyHolder']['holderIdNumber'] = $biz_content['policy_info']['code'];//投保险人证件号码
            $result_content['policyHolder']['holderArea'] =  "110000,110100,110101";  //投保人所在地 暂无，写死
            $result_content['policyHolder']['holderOccupation'] =  '0803027';  //投保人职业编码
            $result_content['policyHolder']['holderIdType'] = $biz_content['policy_info']['card_type'];  //投保险人证件类型
            $result_content['policyHolder']['holderAddress'] = "北京市朝阳区南沙滩小区";    //投保险人详细地址
            $result_content['policyHolder']['holderName'] = $biz_content['policy_info']['name'];   //投保险人姓名
            $result_content['policyHolder']['holderPhone'] = $biz_content['policy_info']['phone'];   //投保险人电话
            $result_content['policyHolder']['holderEmail'] = $biz_content['policy_info']['email']; //投保险人邮箱
            return $result_content;
        }
    }


}