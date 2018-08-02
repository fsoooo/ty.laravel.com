<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/26
 * Time: 15:36
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ApplyRule extends Model{
    protected $table="apply_rule";

    public function cust()
    {
        return $this->hasOne('App\Models\Cust','id','cust_id');
    }
}
