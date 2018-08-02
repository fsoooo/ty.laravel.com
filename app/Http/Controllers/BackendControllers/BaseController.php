<?php

namespace App\Http\Controllers\backendControllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Product;
use App\Models\StatusRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Status;
use Excel;

class BaseController extends Controller
{
    protected $request;
    protected $id;


    public function __construct(Request $request)
    {
        $this->request = $request;
//        $this->id=$_COOKIE["id"];
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
        $result = DB::table('table_field')
            ->where([
                ['table',$table],
                ['field',$field],
            ])->first();
        $count = count($result);
        if($count){
            return $result->id;
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


    //封装一个方法，用来获得所有的渠道
    public function getAllDitch()
    {
        $result = DB::table('ditches')
            ->get();
        return $result;
    }
    //封装一个方法，用来获取所有线上的产品
    public function getAllProduct()
    {
//        $product_list = Product::all();
        $product_list = Product::where('ty_product_id','>=',0)->get();
        return $product_list;
    }
    //封装一个方法，用来获取所有的保险公司
    public function getCompany()
    {
        $company_list = Company::get();
        return $company_list;
    }



    //封装一个方法，通过路由查找路由id
    public function getRouteByPath($path1,$path2){
        $route_id = Route::where('path1',$path1)
            ->where('phth2',$path2)
            ->first();
        return $route_id;
    }
    //封装一个方法，用来进行状态修改限制
    public function changeStatus($parent_id,$status_id)
    {
        //查找是否有状态变更限制
        $isRelation = StatusRule::where('status_id',$status_id)
            ->where('status',0)
            ->count();
        if($isRelation){
            //判断当前状态是否符合条件
            $implement = StatusRule::where('parent_id',$parent_id)
                ->where('status_id',$status_id)
                ->count();
            if($implement){
                return true;
            }
        }
        return false;
    }
}