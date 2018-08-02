<?php
namespace App\Http\Controllers\BackendControllers\Customer;

use App\Models\Agent;
use App\Models\AuthenticationPerson;
use App\Models\CustRule;
use App\Models\Ditch;
use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    //    待实名审核
    public function unverified()
    {
        $users = User::from('users as a')
            ->leftJoin('authentication_person as b', 'b.user_id', '=', 'a.id')
            ->where('b.status', '!=', 2)
            ->select('a.*')
            ->paginate(15);

        return view('backend_v2.customer.unverified',compact('users'));
    }

    //    分配代理人
    public function undistributed(){
        $users = User::from('users as a')
            ->leftJoin('authentication_person as b', 'b.user_id', '=', 'a.id')
//            ->where('b.status', '!=', 2)
            ->select('a.*')
            ->paginate(15);

        return view('backend_v2.customer.undistributed',compact('users'));
    }

    // 分配代理人
    public function allocateAgent($id, Ditch $ditch)
    {
        $ditches = Ditch::orderBy('id', 'asc')->get();

        $ditch_id = request('ditch_id');
        $selected_ditch = [];
        $agents = Agent::join('ditch_agent', 'ditch_agent.agent_id', '=', 'agents.id')
            ->join('ditches', 'ditches.id', '=', 'ditch_agent.ditch_id');

        if ($ditch_id) {
            $selected_ditch = Ditch::where('id', $ditch_id)->first();
            $agents = $agents->where('ditches.id', $ditch_id);
        }

        $agents = $agents->select('ditches.name as ditch_name', 'agents.*')->get();

        foreach ($agents as $agent) {
            $user = User::where('id', $agent->user_id)->first();;
            $agent->name = $user->name;
            $agent->cust_count = CustRule::where('agent_id', $agent->id)->count();
            $auth_person = AuthenticationPerson::where(['user_id' => $user->id, 'status' => 2])->first();
            if (!empty($auth_person)) {
                $agent->verified = 1;
            } else {
                $agent->verified = 0;
            }
        }

        $user_id = $id;
        $user = User::where('id', $user_id)->first();

        return view('backend_v2.customer.allocate_agent',
            compact('ditches', 'ditch_id', 'agents', 'user_id', 'selected_ditch', 'user')
        );
    }

    public function allocateAgentPost(Request $request)
    {
        if (!$user_id = $request->get('user_id')) {
            return response(['content' => '缺少user_id', 'code' => 1], 400);
        }
        if (!$agent_id = $request->get('agent_id')) {
            return response(['content' => '缺少agent_id', 'code' => 2], 400);
        }
        $cust = CustRule::where('user_id', $user_id)->first();
        if (!$cust) {
            $cust = new CustRule();
            $cust->agent_id = $agent_id;
            $cust->user_id = $user_id;
            $cust->save();
        } else {
            $cust->agent_id = $agent_id;
            $cust->user_id = $user_id;
            $cust->save();
        }
        return response(['content' => '操作成功', 'code' => 0], 200);
    }
}
