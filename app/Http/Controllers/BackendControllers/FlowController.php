<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\NodeCondition;
use App\Models\StatusGroup;
use App\Models\TableField;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Flow;
use App\Models\Behaviour;
use App\Models\Node;
use Symfony\Component\Console\Helper\Table;

class FlowController extends BaseController
{
    //显示所有的工作流
    public function index()
    {
        $list = Flow::where('status',0)->get();
        $count = count($list);
        return view('backend.flow.index',compact('list','count'));
    }
    //跳转到添加工作流页面
    public function addFlow()
    {
        //列出方法列表

        $route_list = $this->getRoute();

        //列出所有的状态表

        $table_field_list = $this->getTables();
        return view('backend.flow.AddFlow',['route_list'=>$route_list,'table_field_list'=>$table_field_list]);
    }
    //工作流表单提交
    public function addFlowSubmit()
    {
        $input = Request::all();
        $Flow = new Flow();
        $FlowArray = array(
            'flow_name'=>$input['flow_name'],
            'status'=>0
        );
        $result = $this->add($Flow,$FlowArray);
        if($result){
            return redirect('/backend/flow/index')->with('status','添加成功');
        }else{
            return back()->withErrors('添加失败')->withInput($input);
        }
    }
    //跳转到获取工作流的详细页面
    public function getFlowDetail($flow_id)
    {
        //获取工作流的基本信息和条件
        $is_flow = $this->checkFlow($flow_id);//判断数据库是否有该工作流
        if($is_flow){//说明是，则获取工作流的所有信息
            $flow_detail = Flow::where('id',$flow_id)
                ->with('node')->first();
            $node_count = count($flow_detail->node);
            return view('backend.flow.FlowDetail',compact('flow_detail','node_count'));
        }else{
            return back()->withErrors('非法操作');
        }
    }

    //节点管理,跳转到节点页面
    public function node()
    {
        //读取所有的节点
        $node_list = $this->getAllNode();
        $count = count($node_list);
        return view('backend.flow.node',compact('node_list','count'));
    }

    //跳转到添加节点界面
    public function addNode()
    {
        //获取素有的工作流
        $flow_list = $this->getAllFlow();
        //获取所有的方法路由
        $route_list = $this->getRoute();
        if(!$route_list){
           return back()->withErrors('路由错误，请重试');
        }
        return view('backend.flow.AddNode',compact('route_list','flow_list'));
    }

    //节点表单提交
    public function addNodeSubmit()
    {
        $input = Request::all();
        //将数据插入到节点表中
        $Node = new Node();
        $NodeArray = array(
            'flow_id'=>$input['flow_id'],
            'route_id'=>$input['route_id'],
            'node_name'=>$input['node_name'],
            'describe'=>$input['describe'],
            'status'=>0,
        );
        $result = $this->add($Node,$NodeArray);
        if($result){
            return redirect('backend/flow/node')->with('status','添加成功');
        }else{
            return back()->withErrors('添加失败')->withInput($input);
        }
    }

    //行为流程管理,跳转到行为怪饭页面
    public function behaviour()
    {
        //获取所有的行为规范

        return view('backend.flow.behaviour');
    }

    //跳转到添加行为规范的页面
    public function addBehaviour()
    {
        //获取所有的节点,表名
        $node_list = $this->getAllNode();
        $table_field_list = $this->getTables();
        dd($table_field_list);
        return view('backend/flow/AddBehaviour',compact('flow_detail','route_list','table_field_list'));
    }

    //跳转到节点详情界面
    public function getNodeDetail($node_id)
    {
        //获得对应的方法,判断是否有该节点
        $result = $this->isNode($node_id);
        if($result){
            //获取节点的信息
            $node_detail = Node::where('id',$node_id)
                    ->with('node_flow','node_route')
                    ->first();
            //获取该节点的所有行为规范,行为分两种，可执行和不可执行
            $possible = NodeCondition::where('is_possible',1)->where('node_id',$node_id)->with('node_condition_status')->get();
            $impossible = NodeCondition::where('is_possible',0)->where('node_id',$node_id)->with('node_condition_status')->get();
            $possible_count = count($possible);
            $impossible_count = count($impossible);
            //获取所有的状态分组
            $status_group = StatusGroup::where('status','!=','-1')
                ->get();
            return view('backend.flow.NodeDetail',compact('status_group','node_detail','possible_count','impossible_count','possible','impossible'));
        }else{
            return back()->withErrors('非法操作');
        }
    }

    //节点连接状态
    public function addNodeStatus()
    {
        $input = Request::all();
        //判断是否提交过
        $isSubmit = NodeCondition::where('node_id',$input['node_id'])
            ->where('status_id',$input['status_id'])
            ->get();
        $count = count($isSubmit);
        if($count){
            $id = $isSubmit[0]->id;
            $status = $isSubmit[0]->status;
            if($status){
                return back()->withErrors('已经有该条件了，请勿重复添加');
            }else{
                $NodeCondition = NodeCondition::find($id);
                $NodeConditionArray = array(
                    'is_possible'=>$input['is_possible'],
                    'status'=>0,
                    'return_message'=>$input['return_message'],
                );
                $result = $this->edit($NodeCondition,$NodeConditionArray);
            }
        }else{
            $NodeCondition = new NodeCondition();
            $NodeConditionArray = array(
                'node_id'=>$input['node_id'],
                'status_id'=>$input['status_id'],
                'is_possible'=>$input['is_possible'],
                'return_message'=>$input['return_message'],
                'status'=>0,
            );
            $result = $this->add($NodeCondition,$NodeConditionArray);
        }
        if($result){
            return back()->with('status','添加成功');
        }else{
            return back()->withErrors('添加失败');
        }

    }



    //封装一个方法，用来判断是否有该节点
    public function isNode($node_id)
    {
        $result = Node::where('id',$node_id)
            ->count();
        return $result;
    }



//封装一个方法，用来获取所有的工作流
    public function getAllFlow()
    {
        $flow_list = Flow::get();
        return $flow_list;
    }
    //封装一个方法，用来获取所有的节点
    public function getAllNode()
    {
        $node_list = Node::with('node_flow')->get();
        return $node_list;
    }
    //封装一个方法，用来获取所有的行为规范，并且获取对应节点
    public function getAllBehaviour()
    {
        $behaviour_list = Behaviour::with('behaviour_node')->get();
        return $behaviour_list;
    }
    //封装一个方法，用来获取所有的表名
    public function getTables()
    {
        $table_field_list = TableField::get();
        return $table_field_list;
    }

    //封装一个方法，用来获取所有的方法，即路由
    public function getRoute()
    {
        $result = DB::table('route')
            ->get();
        $count = count($result);
        if($count){
            //说明有记录
            return $result;
        }else{
            return false;
        }
    }
    //封装一个方法，用来判断是否是自己的工作流
    public function checkFlow($flow_id)
    {
        $Flow = Flow::where('id',$flow_id);
        $count = $Flow->count();
        if($count){
            return $Flow->first();
        }else{
            return false;
        }
    }
}
