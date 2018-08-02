<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/5/3
 * Time: 14:08
 */

namespace App\Http\Controllers\BackendControllers;
use App\Http\Controllers\BackendControllers;
use App\Models\StatusGroup;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use Predis\Response\Status;
use Request;
use App\Models\StatusClassify;
use App\Models\StatusClassifyRule;
class StatusClassifyController extends BaseController{


    public function getClassify()
    {
        $input = Request::all();
        $father_id = $input['fid'];
        //通过父id查找状态
        $result = DB::table('status_classify')
            ->join('status_classify_rule','status_classify_rule.status_id','=','status_classify.id')
            ->where('status_classify_rule.status_father_id',$father_id)
            ->select('status_classify.*')
            ->get();
        $count = count($result);
        if($count){
            echo returnJson('200',$result);
        }else{
            echo returnJson('0','无状态');
        }
    }

    //
    public function index()
    {
        //查所有的状态，并查询 对应的表和父状态，跟状态
        $result = DB::table('status_classify_rule')
            ->join('status_classify','status_classify.id','=','status_classify_rule.status_id')
            ->join('table_field','table_field.id','=','status_classify_rule.field_id')
            ->select('status_classify.*','table_field.describe')
            ->get();


        $list = StatusClassify::with('status_classify_rule','status_classify_rule.status_classify_rule_group')
            ->get();
        return view('backend.status.index',compact('list'));
    }
    //添加状态
    public function addStatus()
    {

        //获取所有的表和对应的描述
        $tables = DB::table('table_field')
            ->where('status',0)
            ->get();
       //获取所有的状态分类
        $status_group = $this->getAllStatusGroup();
        $status_count = count($status_group);
        return view('backend.status.add',compact('status_group','tables','status_count'));
    }
    //添加状态表单提交
    public function addStatusSubmit()
    {
        $input = Request::all();
        //添加状态表单,并添加到关系表中
        DB::beginTransaction();
        try{
            $StatusClassify = new StatusClassify();
            $StatusClassifyArray = array(
                'status_name'=>$input['status_name'],
                'describe'=>$input['describe'],
                'status'=>0,
            );
            $result = $this->add($StatusClassify,$StatusClassifyArray);
            //添加到状态关系表中
            $StatusClassifyRule = new StatusClassifyRule();
            $StatusClassifyRuleArray = array(
                'field_id'=>$input['field_id'],
                'status_id'=>$result,
                'group_id'=>$input['group_id'],
                'status'=>0,
            );
            $this->add($StatusClassifyRule,$StatusClassifyRuleArray);
            DB::commit();
            return redirect('/backend/status/index')->with('status','添加成功');
        }catch (Exception $e){
            DB::rollBack();
            return back()->withErrors('添加失败')->withInput($input);
        }
    }

    //跳转到状态分类界面
    public function getGroup()
    {

        $status_group = $this->getAllStatusGroup();
        $count = count($status_group);
        return view('backend.status.StatusGroup',compact('status_group','count'));
    }
    //跳转到添加分组页面
    public function addGroup()
    {
        return view('backend.status.AddGroup');
    }
    //分组表单提交
    public function addGroupSubmit()
    {
        $input = Request::all();
        $StatusGroup = new StatusGroup();
        $StatusGroupArray = array(
            'group_name'=>$input['group_name'],
            'group_describe'=>$input['group_describe'],
            'status'=>0,
        );
        $result = $this->add($StatusGroup,$StatusGroupArray);
        if($result){
            return redirect('backend/status/group')->with('status','添加成功');
        }else{
            return back()->withErrors('添加失败')->withInput($input);
        }
    }

    //封装一个方法，用来获取所有的状态分组
    public function getAllStatusGroup()
    {
        $status_group = StatusGroup::paginate(config('list_num.backend.claim'));
        return $status_group;
    }


    //封装一个方法，用来获取所有的表名
    public function getTables()
    {
        $list = DB::table('table_field')
            ->select('table')
            ->distinct()
            ->get();
        $count = count($list);
        if($count){
            return $list;
        }else{
            return false;
        }
    }
    // 封装一个方法，用来获取层级状态
    public function getSatusByFather($status_father_id)
    {
        $status_list = DB::table('status_classify')
            ->join('status_classify_rule','status_classify.id','=','status_classify_rule.status_id')
            ->where('status_classify_rule.status_father_id',$status_father_id)
            ->get();
        $count = count($status_list);
        if($count){
            return $status_list;
        }else{
            return false;
        }
    }
    //写一个方法，ajax，通过分组，获取该分组下的所有的状态
    public function getStatusByGroupAjax()
    {
        $input = Request::all();
        $group_id = $input['group_id'];
        $result = StatusClassifyRule::where('group_id',$group_id)
            ->with('status_classify')
            ->get();
        echo returnJson('200',$result);
    }

}