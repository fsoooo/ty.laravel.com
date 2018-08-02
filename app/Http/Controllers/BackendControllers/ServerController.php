<?php

namespace App\Http\Controllers\BackendControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Special;
use Illuminate\Support\Facades\DB;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Contracts\Support\JsonableInterface;
class ServerController extends Controller
{
    //发起工单请求
    public function  addSpecial(){
        return view('backend.special.addspecial');
    }
    //处理发起
    public function  doAddSpecial(){
        $title = $_GET['name'];
        $content = $_GET['description'];
        if(empty($title)||empty($content)){
            return (['status' => 'false', 'message' => '标题或内容不能为空！']);
        }
        $company_id =  env('TY_API_ID', '201706221136503001');
        $special = $company_id.time();
        $special = str_shuffle($special);
        $special = substr($special,0,8);
        $url = $_GET['url'];
        $biz_content = array('title'=>$title,'content'=>$content,'company_id'=>$company_id,'special_num'=>$special,'url'=>$url);
        $sign_help = new RsaSignHelp();
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/doaddspecial')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        $contnets = $response->content;
        $status = $response->status;
        if($status == '200'){
            $res = Special::insert([
                'special_num'=>$special,
                'company'=>$company_id,
                'title'=>$title,
                'content'=>$content,
                'created_at'=>date('YmdHis',time()),
                'updated_at'=>date('YmdHis',time()),
            ]);
            if($res){
                return (['status' => 'true', 'message' => '发起工单成功！']);
            }else{
                return (['status' => 'false', 'message' => '发起工单失败！']);
            }
        }else{
            return (['status' => 'false', 'message' => '无服务！']);
        }
    }
    //已发出工单
    public function special(){
        $limit = config('list_num.backend.roles');//每页显示几条
        $params = "/backend/special/special";
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $res = Special::where('delete_id','0')->paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = Special::orderBy('created_at', 'asc')
                ->where('delete_id','0')
                ->skip($page)
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.special.special')
                ->with('res', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        } else {
            $page = '1';
            $res = Special::where('delete_id','0')->paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = Special::orderBy('created_at', 'asc')
                ->where('delete_id','0')
                ->skip($page)
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.special.special')
                ->with('res', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        }

    }

    //删除工单
    public function delSpecial(){
        $res = Special::where('id',$_GET['id'])->update(['delete_id'=>1]);
         if($res){
           return (['status' => 0, 'message' => '工单删除成功']);
        }else{
             return (['status' => 1, 'message' => '工单删除失败']);
        }
    }
    //工单回收站
    public function recSpecial(){
        $limit = config('list_num.backend.roles');//每页显示几条
        $params = "/backend/special/recspecial";
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $res = Special::where('delete_id','1')->paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = Special::orderBy('created_at', 'asc')
                ->where('delete_id','1')
                ->skip($page)
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.special.recspecial')
                ->with('res', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        } else {
            $page = '1';
            $res = Special::where('delete_id','1')->paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = Special::orderBy('created_at', 'asc')
                ->where('delete_id','1')
                ->skip($page)
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.special.recspecial')
                ->with('res', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        }
    }

    public function specialInfo(){
        $res = Special::where('id',$_GET['id'])->first();
        return view('backend.special.detail')->with('res',$res);
    }



    public function hasDoSpecial(){
        $status = $_GET[0]['status'];
        $special_num = $_GET[0]['special_num'];

        if($status == 'on'){
             $res = Special::where('special_num',$special_num)->update([
                'status'=>'1',
                ]);
            return (['status' => 0, 'message' => '工单处理成功！']);
        }
    }




}
