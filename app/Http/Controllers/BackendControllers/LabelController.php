<?php

namespace App\Http\Controllers\BackendControllers;

use Validator, DB;
use App\Models\Label;
use App\Models\LabelRelevance;
use App\Models\User;
use App\Models\Product;
use App\Models\Agent;
use Illuminate\Http\Request;

class LabelController extends BaseController
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    //用户标签
    public function userLabel(){
        $request = $this->request->all();
        $where = array();

        if(isset($request['user_type'])){
            $where[] = ['label_type', $request['user_type']];
        }else{
            $where[] = ['label_type','user'];
        }
        $where_select = [];
        if(isset($request['keyword'])) {
            $keyword = $request['keyword'];
            switch ($request['search_type']) {
                case 'label_group':
                    $where_select[] = ['parent_id',$keyword];
                    break;
            }
        }else{
            if(isset($request['label_type'])&&$request['label_type']=='company'){
                $where_select[] = ['parent_id','5'];
            }else{
                $where_select[] = ['parent_id','4'];
            }
        }
        $label_groups = Label::where($where)
            ->where('label_belong','user')
            ->where('parent_id','0')
            ->where('status','0')
            ->get();
        $label_res = Label::where($where)
            ->where('label_belong','user')
            ->where('parent_id','<>','0')
            ->where($where_select)
            ->where('status','0')
            ->get();
        $labels = Label::where($where)
            ->where($where_select)
            ->where('label_belong','user')
            ->where('status','0')
            ->get();
        return view('backend_v2.label.label_user')
            ->with('labels',$labels)
            ->with('label_groups',$label_groups)
            ->with('label_res',$label_res);
    }
    //代理人标签
    public function agentLabel(){
        $label_groups = Label::where('label_belong','agent')
            ->where('parent_id','0')
            ->where('status','0')
            ->get();
        $label_res = Label::where('label_belong','agent')
            ->where('parent_id','<>','0')
            ->where('status','0')
            ->get();
        $labels = Label::where('label_belong','agent')
            ->where('status','0')
            ->get();
        return view('backend_v2.label.label_agent')
            ->with('labels',$labels)
            ->with('label_groups',$label_groups)
            ->with('label_res',$label_res);
    }
    //产品标签
    public function productLabel(){
        $request = $this->request->all();
        $where = array();
        if(isset($request['label_type'])){
            $where[] = ['label_type', $request['label_type']];
        }else{
            $where[] = ['label_type','global'];
        }
        $where_select = [];
        if(isset($request['keyword'])) {
            $keyword = $request['keyword'];
            switch ($request['search_type']) {
                case 'label_group':
                    $where_select[] = ['parent_id',$keyword];
                    break;
            }
        }else{
            if(isset($request['label_type'])&&$request['label_type']=='special'){
                $where_select[] = ['parent_id','2'];
            }else{
                $where_select[] = ['parent_id','1'];
            }
        }
        $label_groups = Label::where($where)
            ->where('label_belong','product')
            ->where('parent_id','0')
            ->where('status','0')
            ->get();
        $label_res = Label::where($where)
            ->where('label_belong','product')
            ->where('parent_id','<>','0')
            ->where($where_select)
            ->where('status','0')
            ->get();
        $labels = Label::where($where)
            ->where($where_select)
            ->where('label_belong','product')
            ->where('status','0')
            ->get();
        return view('backend_v2.label.label_product')
            ->with('labels',$labels)
            ->with('label_groups',$label_groups)
            ->with('label_res',$label_res);
    }
    //添加/更新标签组
    public function doAddLabelGroup(){
        $request = $this->request->all();
        if(isset($request['label_group_name'])&&count($request['label_group_name'])!=0){
            //插入
            if(empty($request['label_group_name'])){
                return back()->withErrors('请正确输入！');
            }
            foreach ($request['label_group_name'] as $key=>$item) {
                Label::insert([
                    'name'=>$item,
                    'cover'=>$item,
                    'description'=>$item,
                    'parent_id'=>0,
                    'label_type'=>isset($request['label_type'])? $request['label_type'] :'',
                    'label_belong'=>isset($request['label_belong'])? $request['label_belong'] :'',
                    'status'=>0,
                    'created_at'=>date('Y-m-d H:i:s',time()),
                    'updated_at'=>date('Y-m-d H:i:s',time()),
                ]);
            }
        }
        if(isset($request['label_edit'])&&count($request['label_edit'])!=0){
            foreach ($request['label_edit'] as $key=>$item) {
                Label::where('id',$key)->update(['name'=>$item]);
            }
        }
        return back()->with('status','操作成功！');
    }
    //删除标签组
    public function doDellabelGroup(){
        $request = $this->request->all();
        Label::where('id',$request['id'])->update(['status'=>'1']);
        return (json_encode(['status' => 0, 'message' => '操作成功'],JSON_UNESCAPED_UNICODE));
    }
    //添加标签
    public function doAddLabel(){
        $request = $this->request->all();
        if(empty($request['parent_id'])){
            return back()->withErrors('请先添加标签组！');
        }
                Label::insert([
                    'name'=>$request['label_add'],
                    'cover'=>'',
                    'description'=>$request['label_add'],
                    'parent_id'=>$request['parent_id'],
                    'label_type'=>isset($request['label_type'])? $request['label_type'] :'',
                    'label_belong'=>isset($request['label_belong'])? $request['label_belong'] :'',
                    'status'=>0,
                    'created_at'=>date('Y-m-d H:i:s',time()),
                    'updated_at'=>date('Y-m-d H:i:s',time()),
                ]);
        return back()->with('status','添加成功！');
    }
    //删除标签
    public function doDellabel(){
        $request = $this->request->all();
        Label::where('id',$request['id'])->update(['status'=>'1']);
        return back()->with('status','操作成功！');
    }
    //标签和对象关联
    public function doLabelRelevance(){
        $input = $this->request->all();
        if(empty($input['label_id'])){
            return (json_encode(['status' => 500, 'message' => '请选择标签'],JSON_UNESCAPED_UNICODE));
        }
        $check_res = LabelRelevance::where('label_belong',$input['label_belong'])
            ->where('label_relevance',$input['label_relevance'])
            ->first();
       if(is_null($check_res)){
           //插入
           foreach ($input['label_id'] as $value){
               LabelRelevance::insert([
                   'label_relevance'=>$input['label_relevance'],
                   'label_belong'=>$input['label_belong'],
                   'label_type'=>isset($input['label_belong']) ? $input['label_belong'] : "",
                   'label_id'=>$value,
                   'created_at'=>date('Y-m-d H:i:s',time()),
                   'updated_at'=>date('Y-m-d H:i:s',time()),
               ]);
           }
       }else{
           foreach ($input['label_id'] as $value){
               LabelRelevance::insert([
                   'label_relevance'=>$input['label_relevance'],
                   'label_belong'=>$input['label_belong'],
                   'label_type'=>isset($input['label_belong']) ? $input['label_belong'] : "",
                   'label_id'=>$value,
                   'created_at'=>date('Y-m-d H:i:s',time()),
                   'updated_at'=>date('Y-m-d H:i:s',time()),
               ]);
           }
       }
        return (json_encode(['status' => 0, 'message' => '操作成功'],JSON_UNESCAPED_UNICODE));
    }
    //删除标签和对象关联
    public function delLabelRelevance(){
        $input = $this->request->all();
        if(empty($input['label_id'])){
            return (json_encode(['status' => 500, 'message' => '请选择标签'],JSON_UNESCAPED_UNICODE));
        }
        $check_res = LabelRelevance::where('label_id',$input['label_id'])->delete();
        return (json_encode(['status' => 0, 'message' => '操作成功'],JSON_UNESCAPED_UNICODE));
    }






















//    2017-10-23   以前的，不知道还有没有用
    public function index()
    {
        $categories = Label::where('status','on')->select(DB::raw('*, concat(path,id) as npath'))->orderBy('npath', 'asc')->get();
        return view('backend.label.index',compact('categories'));
    }
    public function addLabel()
    {
        $input = $this->request->all();
        $validator = $this->checkAddCategory($input);
        if ($validator->fails()) {
            return redirect('backend/product/category')
                ->withErrors($validator)
                ->withInput();
        }
        
        //添加分类 
        $category = new Label();
        $category->name = $input['name'];
        $category->slug = $input['slug'];
        $category->path = ',' . 0 . ',';
        if(!empty($input['pid'])){
            $parent = Label::where('status','on')->find($input['pid']);
            $category->pid = $parent->id;
            $category->sort = $parent->sort + 1;
            $category->path = $parent->path . $parent->id . ',';
        }

        $category->save();
        return redirect('backend/product/category')->with('status', '成功录入分类信息!');
    }
    /*
    *分类修改
    */
    public function alter()
    {
        $input  = $this->request->all();
        $name   = $input['name'];
        $pid    = $input['pid'];
        $slug   = $input['slug'];
        $result = Label::where(['id'=>$pid])->update(['name' => $name,'slug'=>$slug]);
        if($result){
            return redirect('backend/product/category');
        }else{
            echo '修改失败，请重新修改';
        }
    }
    /*
    *分类的删除  
    */
    public function omit()
    {
        $id = $_GET['id'];
        // 根据id查path下面是否有子级，如果有子级删除所有的子级，如果没有直接删除 
        $del = Label::where('path','like','%'.$id.'%')->select('id')->get()->toArray();
        if ($del) {
            $del[]['id']=$id;
            foreach ($del as $key => $value) {
                // 删除它和它所以子级  
                $res = Label::where(['id'=>$value['id']])->delete();
            }
            if($res){
                return redirect('backend/product/category');
            }else{
                echo '修改失败，请重新修改';
            }
        }else{
            //没有子级，直接删除 
            $result = Label::where(['id'=>$id])->delete();
            if($result){
                return redirect('backend/product/category');
            }else{
                echo '修改失败，请重新修改';
            }
        }           
    }
    protected function checkAddCategory($input)
    {
        //规则
        $rules = [
            'pid' => 'integer|nullable',
            'name' => 'required|string',
            'slug' => 'required|string|unique:category',
        ];

        //自定义错误信息
        $messages = [
            'required' => 'The :attribute is null.',
            'unique' => 'The :attribute is exist',
            'integer' => 'The :attribute mast be integer.',
            'string' => 'The :attribute mast be string.',
        ];
        //验证
        $validator = Validator::make($input, $rules, $messages);
        return $validator;
    }

}