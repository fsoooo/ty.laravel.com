<?php
namespace App\Helper;
use DB;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;

class Relevance{

    protected $signHelp;
    protected $table;
    public function __construct()
    {
        $this->signHelp = new RsaSignHelp();;
    }

    //封装一个方法，用来获取各种关系
    public function getRelevance($type,$api_from_uuid)
    {
        //判断传入参数是否正确
        $type_array = array('occupation','relation','card_type','bank');
        if(!in_array($type,$type_array)){
            $data = array(
                'content'=>'参数错误',
                'status'=>'403'
            );
            return $data;
        }
        $result = DB::table($type)->where('api_from_uuid',$api_from_uuid)
            ->get();
        //说明无数据，进行同步
        if(!count($result)){//说明没有数据，进行数据同步
            if($type == 'occupation'){
                $address = 'profession';
            }else if($type == 'bank'){
                $address = 'bank';
            }else if($type == 'relation'){
                $address = 'relationship';
            }else if($type == 'card_type'){
                $address = 'card_type';
            }

            $biz_content['api_from_uuid'] = $api_from_uuid;
            $url = env('TY_API_SERVICE_URL') .'/api_option/'.$address;
            //天眼接口参数封装
            $data = $this->signHelp->tySign($biz_content);
            //发送请求
            $response = Curl::to($url)
                ->returnResponseObject()
                ->withData($data)
                ->withTimeout(60)
                ->post();
            $status = $response->status;
            if($status == 200)
            {//说明存在数据，进行两部，1，添加到数据库中，2，返回结果
                $return_data = json_decode($response->content);
                $add_array = array();
                foreach($return_data as $value)
                {
                    $add_son_array = array(
                        'api_from_uuid'=>$value->api_from_uuid,
                        'name'=>$value->name,
                        'number'=>$value->number,
                    );
                    if($type == 'bank')
                    {
                        $add_son_array['code'] = $value->code;
                    }
                    array_push($add_array,$add_son_array);
                }
                $add_result = DB::table($type)->insert($add_array);
                if($add_result){
                    $result = DB::table($type)->where('api_from_uuid',$api_from_uuid)
                        ->get();
                }else{
                    $data = array(
                        'content'=>'失败',
                        'status'=>'403'
                    );
                    return $data;
                }
            }else{
                $data = array(
                    'content'=>'请求失败，请重试',
                    'status'=>'403'
                );
                return $data;
            }
        }
        //进行数据返回
        $data = array(
            'content'=>$result,
            'status'=>200
        );
        return $data;
    }



}



