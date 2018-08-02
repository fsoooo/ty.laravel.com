<?php
namespace App\Helper;
use DB;
use App\Models\Product;
use League\Flysystem\Exception;
use App\Models\Message;
use App\Models\MessageRule;
class WebMessage{

    protected $signHelp;
    protected $table;

    /**
     * WebMessage constructor.
     * @param $send_time_type  0 当前发送 1 定时发送
     * @param $send_time 定时发送时间
     */
    //写一个方法，用来发送站内信           //标题  内容     接收类型      发送时间类型    接收人员                发送时间
    public function sendMessage($send_id,$title,$content,$receive_type,$send_time_type,$receive_person=null,$send_time=null)
    {                            //发送人员id，管理员为0
        //判断接收人员类型，0全体人员，1，全体代理人，2，全体客户，3，全体个人客户4，全体企业客户，5.指定成员
        //修改后的，这个是现在库里的状态，0全体人员、1个人用户、2企业用户、3团体组织、4渠道、5指定成员、6代理人
        DB::beginTransaction();
        try{
            //添加数据到信息表中
            $message_id = DB::table('message')->insertGetId(array(
                'title'=>$title,
                'content'=>$content,
            ));
            if($send_time_type == 0){//当前时间发送
                $read_time = time();
            }else{
                $read_time = $send_time;
            }
            if($receive_type == 5){//说明是指定人员发送
                if(is_array($receive_person)){
                    $receive_array = array(
                        'send_id'=>$message_id,
                        'status'=>0,
                        'receive_type'=>5,
                        'read_time'=>$read_time,
                    );
                    $insert_array = array();
                    foreach($receive_person as $value)
                    {
                        $insert_son_array = $receive_array;
                        $insert_son_array['receive_id'] = $value;
                        array_push($insert_array,$insert_son_array);
                    };
                    $result = DB::table('message_rule')
                        ->insert($insert_array);
                }else{
                    echo returnJson(200,'参数错误');
                }
            }else{//说明是某一类人查看
                $result = DB::table('message_rule')->insert(array(
                    'receive_id'=>0,
                    'send_id'=>$send_id,
                    'message_id'=>$message_id,
                    'status'=>0,
                    'receive_type'=>$receive_type,
                    'read_time'=>$read_time
                ));
            }
            if($message_id&&$result){
                DB::commit();
                return returnJson(200,'发送成功');
            }else{
                DB::rollBack();
                return returnJson(403,'发送失败');
            }
        }catch(Exception $e){
            DB::rollBack();
            return returnJson(403,'发送失败');
        }





    }



}



