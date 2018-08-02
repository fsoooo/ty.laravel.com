<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/9/20
 * Time: 16:44
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PlanLists extends Model{
    protected $table = 'plan_lists';
    //人员信息
    public function planRecognizee()
    {
        return $this->hasOne('App\Models\PlanRecognizee', 'id', 'plan_recognizee_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'ty_product_id', 'ty_product_id');
    }

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'plan_id', 'id');
    }

    //关联user表
    public function user()
    {
        return $this->hasOne('App\Models\User','id','plan_recognizee_id');
    }
}