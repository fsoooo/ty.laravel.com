<?php
namespace App\Helper;
use App\Models\StatusRule;
class Status{
    public static $status;

    public static function createStatus()
    {
        if(!self::$status){
            self::$status = new Status();
        }
        return self::$status;
    }


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