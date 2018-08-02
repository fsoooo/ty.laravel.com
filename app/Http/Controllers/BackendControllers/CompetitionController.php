<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/26
 * Time: 10:27
 */

namespace App\Http\Controllers\BackendControllers;

use App\Http\Controllers\backendControllers\BaseController;
use App\Models\Competition;
use App\Models\CompetitionAward;
use App\Models\CompetitionCondition;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use Request;
use App\Models\Agent;
use App\Models\Ditch;
class CompetitionController extends BaseController{



    //跳转到竞赛方案管理页面
    public function index()
    {
        //获取竞赛方案
         //ccccccc 需要添加产品名称和
        $competition_list = Competition::all();
        $count = count($competition_list);
        $type = '';
        return view("backend.business.CompetitionList",['count'=>$count,'competition_list'=>$competition_list,'type'=>$type]);
    }
    //添加新的竞赛方案
    public function addCompetition()
    {
        //获取所有的渠道，并且注入数据
        $ditch_list = $this->getAllDitch();
        $product_list = $this->getAllProduct();
        return view('backend.business.CreateCompetition',compact('ditch_list','product_list'));
    }
    //添加竞赛方案表单提交
    public function addCompetitionSubmit()
    {
        $input = Request::all();
        //插入信息到竞赛方案表中
        $time = date('Y-m-d H:i:s',time());
        if($input['start_time']<=$time){
            $input['start_time']=$time;
        }
        if($input['end_time']<=$time){
            $input['end_time']=$time;
        }
        $Competition = new Competition();
        $CompetitionArray = array(
            'start_time'=>$input['start_time'],
            'end_time'=>$input['end_time'],
            'product_id'=>$input['product_id'],
            'condition_type'=>$input['condition_type'],
            'status'=>0,
            'name'=>$input['competition_name'],
        );
        $competition_id = $this->add($Competition,$CompetitionArray);
        if($competition_id) {
            return redirect('/backend/business/competition')->with('status', '添加成功');
        }else {
            return back()->withErrors('添加失败');
        }
    }
    //插入条件和奖励
    public function addConditionSubmit()
    {
        $input = Request::all();
//        dd($input);
        $min_sum = $input['min_sum']?$input['min_sum']:0;
        $max_sum = $input['max_sum']?$input['max_sum']:0;
        $min_count = $input['min_count']?$input['min_count']:0;
        $max_count = $input['max_count']?$input['max_count']:0;
        $rate = $input['rate']?$input['rate']:0;
        $reward = $input['reward']?$input['reward']:0;
        $CompetitionCondition = new CompetitionCondition();
        $condition_array = array(
            'competition_id'=>$input['competition_id'],
            'award_type'=>$input['award_type'],
            'min_count'=>$min_count,
            'max_count'=>$max_count,
            'min_sum'=>$min_sum*100,
            'max_sum'=>$max_sum*100,
            'rate'=>$rate,
            'reward'=>$reward*100,
            'status'=>0,
        );
        $result = $this->add($CompetitionCondition,$condition_array);
        if($result){
            return back()->with('status','添加成功');
        }else{
            return back()->withErrors('添加失败');
        }
    }

    //查询竞赛方案的详细信息
    public function getDetail($competition_id){
        $detail = Competition::where('id',$competition_id)
            ->with('competition_condition')
            ->with('competition_product')
            ->first();
//        dd($detail);
        //获取素有的产品
        return view('backend.business.CompetitionDetail',compact('detail'));
    }
    //已过期的方案
    public function getExpireCompetition()
    {
        $time = date('Y-m-d');
        $competition_list = Competition::where('end_time','<',$time)
            ->get();
        $count = count($competition_list);
        $type = 'expire';
        return view("backend.business.CompetitionList",['count'=>$count,'competition_list'=>$competition_list,'type'=>$type]);
    }


    //ajax接口，通过竞赛方案获取代理人
    public function getAgentsByDitchAjax()
    {
        $input = Request::all();
        //获取代理人及其所对应的所有渠道
//        $result = DB::table('agents')
//            ->join('ditch_agent','ditch_agent.agent_id','=','agents.id')
//            ->join('ditches','ditch_agent')
    }

}