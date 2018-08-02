<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/26
 * Time: 15:36
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CustRule extends Model{
    protected $table="cust_rule";
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public $fillable = [
        'code','user_id','from_id','agent_id','type','from_type','status'
    ];

}
