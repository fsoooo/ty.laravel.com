<?php

namespace App\Http\Controllers\FrontendControllers;

use App\Http\Controllers\Controller;
use App\Models\AuthenticationPerson;
use App\Models\Label;
use App\Models\MarketDitchRelation;
use App\Models\Node;
use App\Models\NodeCondition;
use App\Models\Order;
use App\Models\Product;
use App\Models\Route;
use App\Models\Status;
use App\Models\TableField;
use App\Models\Warranty;
use Illuminate\Support\Facades\DB;
use App\Models\Agent;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
use App\Models\User;
class BaseController extends Controller
{
    protected $id;
    protected $signHelp;

    public function __construct()
    {
        $this->signHelp = new RsaSignHelp();
    }
    //判断是否是手机浏览器登录
    function is_mobile()
    {
        //正则表达式,批配不同手机浏览器UA关键词。
        $regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
        $regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
        $regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
        $regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
        $regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
        $regex_match.=")/i";
        return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT'])); //如果UA中存在上面的关键词则返回真。
    }
    //方法，用来获取自己的id
    public function getId()
    {
        if(isset($_GET['account'])){
            $account = User::where('phone',$_GET['account'])->first();
            setcookie('user_id',$account->id);
            setcookie('login_type',$account->type);
            setcookie('user_name',$account->name);
            setcookie('user_type','channel');
        }else{
            if(!isset($_COOKIE['login_type'])){
                return redirect(('/login'));
            }
        }
        if(isset($_GET['account'])){
            $user_id = User::where('phone',$_GET['account'])->first()->id;
            return isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : $user_id;
        }else{
            return $_COOKIE['user_id'];
        }
    }

    //获取代理人id
    public function getAgentId($id)
    {
        $id = Agent::where('user_id',1)
            ->where('status','on')
            ->pluck('id');
    }

    //判断自己是否是代理人
    public function checkAgent()
    {
        return $_COOKIE['agent_id'];
    }
    //判断是否已经实名认证
    public function isAuthentication($id)
    {
        $authentication = DB::table('users')
            ->join('agents','agents.user_id','users.id')
            ->join('authentication_person','authentication_person.user_id','users.id')
            ->where('agents.id',$id)
//            ->where('authentication_person.status','<>',1)
            ->select('authentication_person.*','agents.job_number as num')
            ->first();
        if($authentication){
            return $authentication->status;
        }else{
            return $authentication;
        }
//        $user = User::find($id);
//        $code = $user->code;
//        if($code){
//            return true;
//        }else{
//            return false;
//        }
    }


    //封装一个方法，用来获取自己的所有渠道
    public function getMyDitch($agent_id)
    {
        //获取代理人的所有的渠道
        $dith_id = Agent::with('ditches')
            ->where('id',$agent_id)
            ->first();
        $dith_id = $dith_id->ditches[0]['id'];

        return $dith_id;
    }

    //封装一个方法，用来获取所有的自己可以代理的产品
    public function getMyAgentProduct($agent_id,$has_offline = 0)
    {
//        $ditch = $this->getMyDitch($agent_id);
//        $ditch_array = array();
//        $count = count($ditch->ditches);
//        //说明有渠道
//        if($count){
//            $ditch_array = $this->changeStdclassToArray($ditch->ditches,'id');
//            //渠道统一的佣金
//            $ditch_brokerage_product = MarketDitchRelation::where('type','ditch')
//                ->whereIn('ditch_id',$ditch_array)
//                ->get();
//            $ditch_brokerage_array = $this->changeStdclassToArray($ditch_brokerage_product,'product_id');
//        }else{
//            //说明无渠道
//            $ditch_brokerage_array = [];
//        }
//        //获取统一佣金的所有产品
//        $unite_brokerage_product = MarketDitchRelation::where('type','product')
//            ->get();
//        $unite_brokerage_array = $this->changeStdclassToArray($unite_brokerage_product,'product_id');
//        //无渠道统一佣金产品
//        $other_brokerage_product = MarketDitchRelation::where('type','other')
//            ->where(function($a)use($agent_id){
//                $a->where('agent_id',0)
//                    ->orwhere('agent_id',$agent_id);
//            })
//            ->get();
//        $other_brokerage_array = $this->changeStdclassToArray($other_brokerage_product,'product_id');
        //取并集
//        $product_array = array_merge($ditch_brokerage_array,$unite_brokerage_array,$other_brokerage_array);
        $marketQuery = MarketDitchRelation::where([
            ['agent_id',$agent_id],
            ['status','on']
        ]);
        if($has_offline == 0){
            $marketQuery->where('ty_product_id','>',0);
        }
        $market = $marketQuery->pluck('ty_product_id');
        $result = Product::whereIn('ty_product_id',$market)
            ->orderBy('updated_at','DESC')
            ->get();
        return $result;
    }








    //封装一个方法，用来将stdclass变为array，取需要的字段
    public function changeStdclassToArray($stdclass_obj,$field)
    {
        $result = array();
        foreach($stdclass_obj as $value)
        {
            array_push($result,$value->$field);
        }
        return $result;
    }
    //封装一个添加的方法,添加数据
    public function add($table,$array){
        foreach($array as $key=>$value){
            $table->$key = $value;
        }
        $table->save();
        return $table->id;
    }
    //封装一个更新数据的方法
    public function edit($table,$array){
        foreach($array as $key=>$value){
            $table->$key = $value;
        }
        $result = $table->save();
        return $result;
    }

    //封装一个方法，查找对应表，字段对应的id值
    public function getFieldId($table,$field)
    {
        $result = TableField::where('table',$table)
            ->where('field',$field)->first();
        if($result){
            return $result->id;
        }else{
            return false;
        }
    }
    //封装一个方法，通过表字段id查找最高层状态
    public function getFatherStatusByFieldId($field_id)
    {
        $result = DB::table('status_classify_rule')
            ->where('field_id',$field_id)
            ->where('status_father_id',0)
            ->first();
        $count = count($result);
        if($count){
            return $result->status_id;
        }else{
            return false;
        }
    }
    //封装一个方法，通过父状态查找子状态
    public function getStatusBy($status_father_id)
    {
        $result = DB::table('status_classify_rule')
            ->join('status_classify','status_classify.id','=','status_classify_rule.status_id')
            ->where('status_classify_rule.status_father_id',$status_father_id)
            ->select('status_classify.*')
            ->get();
        $count = count($result);
        if($count){
            return $result;
        }else{
            return false;
        }
    }
    //封裝一個方法，通過field_id查找對應的狀態
    public function getStatusByFieldId($field_id)
    {
        $status_array = Status::where('field_id',$field_id)
            ->get();
        return $status_array;
    }
    //封装一个条件，用来获取所有的保单
    public function getAllWarranty($id)
    {
        $warranty_list = Warranty::with('warranty_status')
            ->paginate(config('list_num.frontend.warranty'));
        return $warranty_list;
    }

    //封装一个方法，用来获取某个客户所有的订单
    public function getAllOrderFunc($user_id)
    {
        $order_list = Order::where('user_id',$user_id)
            ->orderBy('created_at','desc')
            ->paginate(config('list_num.frontend.order'));
        return $order_list;
    }
    //写一个方法，用来通过类型查找订单状态
    public function getOrderByType($type)
    {

    }



    //封装一个方法，通过路由查找路由id
    public function getRouteByPath($path1,$path2){
        $route_array = Route::where('path1',$path1)
            ->where('path2',$path2)
            ->first();
        if($route_array){
            $route_id = $route_array->id;
        }else{
            $route_id = false;
        }
        return $route_id;
    }
    //封装一个方法，通过路由查找节点
    public function getNodeByRoute($route_id)
    {
        $node_array = Node::where('route_id',$route_id)
            ->first();
        if($node_array){
            $node_id = $node_array->id;
        }else{
            $node_id = false;
        }
        return $node_id;
    }
    //封装一个方法，通过节点查找条件，并进行分类
    public function getNodeConditionByNode($node_id)
    {
        $node_condition_array = NodeCondition::where('node_id',$node_id)
            ->get();
        $count = count($node_condition_array);
        if($count){

        }
    }

    //封装一个方法，用来发送请求
    public function curl_url($biz_content,$url)
    {
        //天眼接口参数封装
        $data = $this->signHelp->tySign($biz_content,['api_from_uuid'=> 'Wk']);
        //发送请求
        $response = Curl::to($url)
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();

    }
    //封装一个方法，用来来获取保险分类的一级分类
    public function getFirstClassify()
    {
        $classify_list = Label::where('parent_id',0)
            ->get();
        return $classify_list;
    }

    //封装一个方法，用来获取产品的详细信息
    public function getProductDetailById($product_id)
    {
        $product_detail = Product::where('id',$product_id)
            ->first();
        return $product_detail;
    }

    //个人或企业用户的验证方法
    public function is_person($id)
    {
        $data = User::where('id',$id)->first();
        if($data['type'] == 'user'){
            $res = 1; //个人
        }else{
            $res = 2; //企业
        }
        return $res;
    }

    //获取代理人可以代理的产品
    public function getMyProducts($agent_id,$where=null)
    {
        $market = MarketDitchRelation::where('agent_id', $agent_id)->pluck('ty_product_id');
        if($where){
            $result = Product::whereIn('ty_product_id',$market)
                ->where('ty_product_id','>=',0)
                ->where($where)
                ->get();
        }else{
            $result = Product::whereIn('ty_product_id',$market)
                ->where('ty_product_id','>=',0)
                ->get();
        }
        return $result;
    }
    
    //获取个人用户是否认证
    public function isAuthenticationPerson($id)
    {
        $data = User::where('id',$id)
            ->whereHas('user_authentication_person')
            ->first();
        if($data){
            return 1;
        }else{
            return 0;
        }
    }
    
    //获取产品的责任
    public function getProductDuties($ty_product_id)
    {
        $biz_content = [
            'ty_product_id' => $ty_product_id,    //投保产品ID
        ];
        //天眼接口参数封装
        $data = $this->signHelp->tySign($biz_content);
//        dd($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/getapioption')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(120)
            ->post();
        return $response;
    }

    //获取代理人的user表的id
    public function getAgentUserId()
    {
        $data = User::whereHas('agent',function($q){
            $q->where('id',$_COOKIE['agent_id']);
        })->pluck('id')->first();
        if($data){
            return $data;
        }else{
            return 0;
        }
    }

    //保险公司二维数组去掉重复值
    public function array_unique_company($array2D){
        foreach ($array2D as $k=>$v){
            $v=join(',',$v);  //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[$k]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $array=explode(',',$v); //再将拆开的数组重新组装
            //下面的索引根据自己的情况进行修改即可
            $temp2[$k]['id'] =$array[0];
            $temp2[$k]['name'] =$array[1];
            $temp2[$k]['display_name'] =$array[2];
            $temp2[$k]['category_id'] =$array[3];
            $temp2[$k]['code'] =$array[4];
            $temp2[$k]['logo'] =$array[5];
            $temp2[$k]['bank_type'] =$array[6];
            $temp2[$k]['bank_num'] =$array[7];
            $temp2[$k]['email'] =$array[8];
            $temp2[$k]['url'] =$array[9];
        }
        return $temp2;
    }

    //保险分类
    public function array_unique_category($array2D){
        foreach ($array2D as $k=>$v){
            $v=join(',',$v);  //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[$k]=$v;
        }
        $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $array=explode(',',$v); //再将拆开的数组重新组装
            //下面的索引根据自己的情况进行修改即可
            $temp2[$k]['id'] =$array[0];
            $temp2[$k]['name'] =$array[1];
            $temp2[$k]['pid'] =$array[2];
            $temp2[$k]['sort'] =$array[3];
            $temp2[$k]['slug'] =$array[4];
            $temp2[$k]['path'] =$array[5];
            $temp2[$k]['status'] =$array[6];
        }
        return $temp2;
    }
}