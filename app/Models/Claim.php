<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/26
 * Time: 15:36
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Claim extends Model{
    protected $table = "claim";


    //关联表
    public function claim_claim_rule()
    {
        return $this->hasOne('App\Models\ClaimRule','claim_id','id');
    }
    //关联单据表
    public function claim_url()
    {
        return $this->hasMany('App\Models\ClaimUrl','claim_id','id');
    }
    //关联状态
    public function claim_status()
    {
        return $this->hasOne('App\Models\Status','id','status');
    }
    
    //关联理赔处理表
    public function claim_record()
    {
        return $this->hasOne('App\Models\ClaimRecord','claim_id','id');
    }
}
