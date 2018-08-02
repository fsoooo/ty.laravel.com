<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;


use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\User;

use Request;
use Illuminate\Support\Facades\Schema;
use App\Models\LiabilityDemand;

use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;


class LiabilityDemandController extends BaseController
{
    //
    protected $signHelp;
    protected $isAuthentication;
    public function __construct()
    {
        $this->signHelp = new RsaSignHelp();
        $id = $this->getId();
        $this->isAuthentication = $this->isAuthentication($id);

    }
    //跳转到添加需求页面
    public function index()
    {
        if(!$this->isAuthentication){
            return redirect(url('/information/change_information'))->withErrors('尚未进行实名认证，请完善个人信息');
        }
        //获取所有的责任
        $url = env('TY_API_SERVICE_URL') .'/duty';
        $data = $this->signHelp->tySign([]);
        //发送请求
        $result = Curl::to($url)
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        $status = $result->status;
        if($status == 200){
            $clause_list = json_decode($result->content);
        }else{
            $clause_list = 0;
        }
        return view('frontend.guests.demand.index',compact('clause_list'));
    }
    //写一个方法，通过责任id查找所有的参数
    public function getTraiffByClauseId()
    {
        $input = Request::all();
        $clause_id = $input['clause_id'];
        $url =env('TY_API_SERVICE_URL') .'/duty/'.$clause_id;
//        $clause_list = $this->curl_url([],$url);
        //天眼接口参数封装
        $data = $this->signHelp->tySign([]);
        //发送请求
        $response = Curl::to($url)
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        $status = $response->status;
        if($status == 200)
        {
            $return_data = json_decode($response->content);
            //判断是否有配置文件中不存在的解析值
            foreach($return_data as $value)
            {
                if(!config('tariff_parameter.'.$value)){//说明配置文件中没有，则请求后台
                    $data = $this->signHelp->tySign([]);
                    $url1 = env('TY_API_SERVICE_URL') .'/parameter_analysis';
                    //发送请求
                    $analysis_data = Curl::to($url1)
                        ->returnResponseObject()
                        ->withData($data)
                        ->withTimeout(60)
                        ->post();
                    $analysis_status = $analysis_data->status;
                    if($analysis_status == 200){
                        $return_analysis_data = json_decode($analysis_data->content);
                    }else{
                        echo returnJson('0','内部错误');
                    }
                    $path = '../config/tariff_parameter.php';

                    if (!file_exists(public_path($path))) {
                        file_put_contents(public_path($path),'');
                    }
                    $tariff_parameter_array = array();
                    foreach ($return_analysis_data as $value)
                    {
                        $tariff_parameter_array[$value->name] = $value->comment;
                    }
                    $fp = fopen('../config/tariff_parameter.php', 'a+b');
                    file_put_contents("../config/tariff_parameter.php","");
                    fwrite($fp,'<?php return ');
                    fwrite($fp, var_export($tariff_parameter_array, true));
                    fwrite($fp,';');
                    fclose($fp);
                }
                $result_array = array();
                foreach($return_data as $value)
                {
                    $result_array[$value] = config('tariff_parameter.'.$value);
                }
            }
            echo returnJson(200,$result_array);
        }else{
            echo returnJson(400,'请求参数失败，请重试');
        }
    }
    //需求表单提交
    public function addDemandSubmit()
    {
        $id = $this->getId();
        $code = User::where('id',$id)->first()->code;
//        ccccccc  加判断，判断当前用户的类型


        $date = date('Ymd',time());
        $random = rand(0,9999999);
        $random_number = substr('0000000'.$random,-7);
        $demand_code = ($date.$random_number);

        $input = Request::all();
        $describe = $input['demand_describe'];
        unset($input['_token']);
        unset($input['describe']);
        unset($input['clause_id']);
        unset($input['demand_describe']);
        $demand_options = json_encode($input);
        //添加数据
        $LiabilityDemand = new LiabilityDemand();
        $LiabilityDemandArray = array(
            'code'=>$code,
            'demand_describe'=>$describe,
            'demand_options'=>$demand_options,
            'demand_code'=>$demand_code,
            'create_user_id'=>$id,
            'create_type'=>0,
            'status'=>0,
            'is_deal'=>0,
        );
        $result = $this->add($LiabilityDemand,$LiabilityDemandArray);
        if($result){
            return back()->with('status','添加成功');
        }else{
            return back()->withErrors('添加失败')->withInput($input);
        }
    }
    //getMyDemand跳转到我的需求界面
    public function getMyDemand($type)
    {
        $id = $this->getId();
        $demand_list = $this->getDemandByDeal($type);
        $count = count($demand_list);
        return view('frontend.guests.demand.DemandList',compact('demand_list','type','count'));
    }
    //封装一个方法，用来获取不同条件的需求
    public function getDemandByDeal($type){
        $id = $this->getId();
        if($type == 'all'){
            $condition_array = [['status',0],['create_type',0]];
        }else if($type == 'deal'){
            $condition_array = [['status',0],['create_type',0],['is_deal',1]];
        }else if($type == 'no_deal'){
            $condition_array = [['status',0],['create_type',0],['is_deal',0]];
        }else{
            return false;
        }
        $demand_list = LiabilityDemand::where($condition_array)->with('demand_user')->where('create_user_id',$id)->orderBy('updated_at','asc')->paginate(config('list_num.backend.demand'));
//        dd($demand_list);
        return $demand_list;
    }


}
