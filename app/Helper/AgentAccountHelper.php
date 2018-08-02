<?php
namespace App\Helper;
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/7/5
 * Time: 20:20
 */

class AgentAccountHelper{
    //封装一个方法，添加到记录中
    public function addAgentAccountRecord($agent_id,$money,$operate,$competition_id)
    {
        $account_sum = AgentAccount::where('agent_id',$agent_id)  //账户余额
            ->first()->sum;
        $balance = $account_sum + $money;
        //添加记录
        $AgentAccountRecord = new AgentAccountRecord();
        $agent_account_record_array = array(
            'money'=>$money,
            'agent_id'=>$agent_id,
            'operate'=>$operate,
            'status'=>0,
            'balance'=>$balance,
            'competition_id'=>$competition_id,
        );
        $result = $this->edit($AgentAccountRecord,$agent_account_record_array);
        //修改账户余额
        $this->changeAgentAccount($agent_id,$balance);
    }

    //封装一个方法，修改账户余额
    public function changeAgentAccount($agent_id,$money)
    {
        $brokerage = AgentAccount::where('agent_id',$agent_id)->first();
        if(!$brokerage){//说明没有账户，添加
            $AgentAccount = new AgentAccount();
            $agent_account_array = array(
                'sum'=>0,
                'settlement_date'=>0,
                'agent_id'=>$agent_id,
            );
            $this->add($AgentAccount,$agent_account_array);
        }
        $brokerage = AgentAccount::where('agent_id',$agent_id)->first();
        $sum = $brokerage->sum+$money;
        $brokerage->sum = $sum;
        $result = $brokerage->save();
        return $result;
    }
}


