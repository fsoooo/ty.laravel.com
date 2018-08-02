<?php

namespace App\Http\Controllers\BackendControllers\Customer;

use App\Models\ChannelPrepareInfo;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRule;
use Illuminate\Http\Request;
use App\Models\OrderParameter;
use App\Models\WarrantyRecognizee;
use Illuminate\Support\Facades\DB;
use App\Models\AuthenticationPerson;

/**
 * 个人客户管理
 * 投保次数：支付成功的订单数
 * 产生保费：所有支付的订单记录的premium
 * 产生佣金：支付的订单 -> company_brokerage brokerage相加
 *
 * @package App\Http\Controllers\BackendControllers\Customer
 */
class IndividualUserController
{
    /**
     * 个人客户列表页
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $with['order'] = function ($q) {
            $q->with('companyBrokerage')->where('status', config('attribute_status.order.payed'))->select();
        };
        $users = User::with($with)
            ->leftJoin('cust_rule', 'cust_rule.user_id', '=', 'users.id')
            ->leftJoin('agents', 'agents.id', '=', 'cust_rule.agent_id')
            ->leftJoin('users as users2', 'users2.id', '=', 'agents.user_id');

        $status = (int)$request->get('status') ? (int)$request->get('status') : '0';
//dd($status);
        if ($status == 1) {
            $tmp = AuthenticationPerson::from('authentication_person as a')
                ->join('users as b', 'b.id', '=', 'a.user_id')
                ->where('a.status', 2)
                ->pluck('user_id');
            if ($tmp) {
                $tmp = $tmp->toArray();
            } else {
                $tmp = [];
            }
            $users = $users->whereNotIn('users.id', $tmp);
        } elseif ($status == 2) {
            $users = $users->join('authentication_person as b', 'users.id', '=', 'b.user_id')
                ->where('b.status', $status);
        }
        $users = $users->where('users.type', 'user')
            ->select('users.*', 'users2.name as agent_name')
            ->paginate(4);

        foreach ($users as $user) {
            // 投保次数
            $user->insure_count = $user->order->count(); // 支付成功的订单数
            // 产生保费
            $user->premium = $user->order->sum('premium') / 100; // 支付成功的订单保费累加
            // 佣金
            $brokerage = 0;
            foreach ($user->order as $order) {
                $brokerage += $order->companyBrokerage->brokerage??"" / 100; // 支付成功的订单关联的公司佣金累加
            }
            // 产生佣金
            $user->brokerage = $brokerage;
            // 实名状态
            $user->verify = AuthenticationPerson::where(['user_id'=>$user->id, 'status'=>2])->first() ? 1 : 0;
        }
        //渠道用户
        $channel_users = ChannelPrepareInfo::with(['channelOperateRes','channelOperateRes.order','channelOperateRes.warranty','channelOperateRes.warranty.warranty'])->paginate(4);
        //被保人
//        $resognizee  = WarrantyRecognizee::with('order.order_brokerage','order.warranty_rule','order.warranty_rule.warranty','order.product','order.order_agent')->groupBy('code')->get();
        return view('backend_v2.customer.individual.index', compact('resognizee','users', 'channel_users','status'));
    }

    /**
     * 个人客户信息页面
     *
     * @param $id user_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function detail($id)
    {
        $list_types = ['insure', 'insured']; //　列表类型 insure投保产品 insured被保产品
        $list_type = request('list');
        if (false === array_search($list_type, $list_types)) {
            return redirect(route('backend.customer.individual.detail', [$id]) . '?list=insure');
        }

        $with['order'] = function ($q) {
            $q->where('status', config('attribute_status.order.payed'))->select();
        };
        $user = User::with($with)
            ->leftJoin('cust_rule', 'cust_rule.user_id', '=', 'users.id')
            ->leftJoin('agents', 'agents.id', '=', 'cust_rule.agent_id')
            ->leftJoin('users as users2', 'users2.id', '=', 'agents.user_id')
            ->leftJoin('ditches', 'ditches.id', '=', 'agents.id')
            ->where(['users.type' => 'user', 'users.id' => $id])
            ->select('users.*', 'users2.name as agent_name', 'ditches.name as ditch_name')
            ->first();

        // 是否实名
        $auth_person = AuthenticationPerson::where(['user_id' => $user->id, 'status' => 2])->first();
        if (!empty($auth_person)) {
            $user->verified = 1;
        } else {
            $user->verified = 0;
        }

        // 产生保费
        $user->premium = $user->order->sum('premium') / 100;
        // 保障数量
        $user->product_count = $user->order->groupBy('ty_product_id')->count();

        $user->sex = $this->getSex($user->code);

        $select = [
            'warranty.warranty_code', // 保单号
            'warranty_rule.id',
            'order.premium', // 保费
            'warranty.status',
            'warranty.start_time', // 承保时间
            'warranty.end_time', // 结束时间
            'order.by_stages_way', // 缴费方式
            'order_brokerage.user_earnings', // 代理人佣金
            'product.product_name', // 产品名称
            'warranty_recognizee.name as recognizee_name', // 被保人名
            'warranty_policy.name as policy_name', // 投保人名
            DB::raw('sum('.DB::getTablePrefix().'company_brokerage.brokerage) as brokerage')
        ];
        $lists = Order::join('warranty_rule', 'order.id', '=', 'warranty_rule.order_id')
            ->join('warranty_recognizee', 'order.id', '=', 'warranty_recognizee.order_id')
            ->join('product', 'product.ty_product_id', '=', 'order.ty_product_id')
            ->join('warranty_policy', 'warranty_rule.policy_id', '=', 'warranty_policy.id')
            ->join('warranty', 'warranty.id', '=', 'warranty_rule.warranty_id')
            ->leftJoin('order_brokerage', 'order_brokerage.order_id', '=', 'order.id')
            ->leftJoin('company_brokerage', 'order.id', '=', 'company_brokerage.order_id')
            ->where(['order.user_id' => $id, 'order.status' => config('attribute_status.order.payed')])
            ->select($select)
            ->paginate(15);

        foreach ($lists as $list) {
            $list->brokerage = $list->brokerage / 100;
            $list->premium = $list->premium / 100;
            $list->user_earnings = $list->user_earnings / 100;
        }

        //  购买保险次数
        $lists2 = Order::where('status', config('attribute_status.order.payed'))
            ->where('user_id', $id)
            ->where(DB::raw('DATE_FORMAT(pay_time,"%Y")'), date('Y'))
            ->groupBy(DB::raw('DATE_FORMAT(pay_time,"%c")'))
            ->select(
                DB::raw('count(*) as count'),
                DB::raw('DATE_FORMAT(pay_time,"%c") as month')
            )
            ->get()->toArray();

        $result1_month = [];
        foreach ($lists2 as $key => $item) {
            $result1_month[] = (int)$item['month'];
        }
        $month = range(1, 12);
        $diff_month = array_diff($month, $result1_month);
        foreach ($diff_month as $item) {
            $lists2[] = [
                'month' => $item,
                'count' => 0
            ];
        }
        array_multisort(array_column($lists2,'month'),SORT_ASC, $lists2);

        return view('backend_v2.customer.individual.detail', compact('user', 'lists', 'list_type', 'lists2'));
    }

    // 保险记录
    public function insurance($id)
    {
        $user = User::where(['type' => 'user', 'id' => $id])->first();
        // 投保产品列表
        $select = [
            'warranty.warranty_code',
            'warranty.start_time',
            'warranty.end_time',
            'warranty.status',
            'order.premium',
            'order.id',
            'order.pay_time',
            'order.order_code',
            'product.json',
            'product.product_name',
            'warranty_recognizee.name as recognizee_name',
            'warranty_policy.name as policy_name',
            'order_brokerage.user_earnings',
            'users.name as agent_name',
            DB::raw('sum('.DB::getTablePrefix().'company_brokerage.brokerage) as brokerage')
        ];
        $lists = Order::where('order.user_id', $id)
            ->join('warranty_rule', 'order.id', '=', 'warranty_rule.order_id')
            ->join('warranty_recognizee', 'order.id', '=', 'warranty_recognizee.order_id')
            ->join('product', 'product.ty_product_id', '=', 'order.ty_product_id')
            ->join('warranty_policy', 'warranty_rule.policy_id', '=', 'warranty_policy.id')
            ->join('warranty', 'warranty_rule.warranty_id', '=', 'warranty.id')
            ->leftJoin('order_brokerage', 'order_brokerage.order_id', '=', 'order.id')
            ->leftJoin('company_brokerage', 'order.id', '=', 'company_brokerage.order_id')
            ->leftJoin('agents', 'agents.id', '=', 'order.agent_id')
            ->leftJoin('users', 'users.id', '=', 'agents.user_id')
            ->select($select)
            ->paginate(15);

        foreach ($lists as $list) {
            $list->brokerage = $list->brokerage / 100;
            $list->premium = $list->premium / 100;
            $list->user_earnings = $list->user_earnings / 100;
            $parameters = json_decode($list->json, true);
            // 分类名
            $list->category = '';
            if (!empty($parameters['category']['name'])) {
                $list->category = $parameters['category']['name'];
            }
            // 公司名
            $list->company = '';
            if (!empty($parameters['company']['name'])) {
                $list->company = $parameters['company']['name'];
            }
        }

        return view('backend_v2.customer.individual.insurance', compact('user', 'lists'));
    }

    public function warranty($id)
    {
        $select = [
            'warranty.warranty_code',
            'order.ty_product_id',
            'order.order_code',
            'order.by_stages_way',
            'order.premium',
            'order.agent_id',
            'order.user_id',
            'order.id as order_id',
            'order_brokerage.user_earnings',
            'users.name as agent_name',
            'ditches.name as ditch_name',
            'warranty_policy.id as policy_id',
            'warranty_rule.beneficiary_id',
            DB::raw('sum('.DB::getTablePrefix().'company_brokerage.brokerage) as brokerage')
        ];
        $warranty = WarrantyRule::join('order', 'order.id', '=', 'warranty_rule.order_id')
            ->join('warranty', 'warranty.id', '=', 'warranty_rule.warranty_id')
            ->join('warranty_policy', 'warranty_policy.id', '=', 'warranty_rule.policy_id')
            ->leftJoin('agents', 'agents.id', '=', 'order.agent_id')
            ->leftJoin('users', 'users.id', '=', 'agents.user_id')
            ->leftJoin('ditch_agent', 'ditch_agent.agent_id', '=', 'agents.id')
            ->leftJoin('ditches', 'ditches.id', '=', 'ditch_agent.ditch_id')
            ->leftJoin('order_brokerage', 'order_brokerage.order_id', '=', 'order.id')
            ->leftJoin('company_brokerage', 'order.id', '=', 'company_brokerage.order_id')
            ->where('warranty_rule.id', $id)
            ->select($select)
            ->first();
        $warranty->brokerage = $warranty->brokerage / 100;
        $warranty->premium = $warranty->premium / 100;
        $warranty->user_earnings = $warranty->user_earnings / 100;
        $product = Product::where('ty_product_id', $warranty->ty_product_id)->first();
        $order_parameter = OrderParameter::where('ty_product_id', $product->ty_product_id)->first();
        $parameters = json_decode($order_parameter->parameter, true);
        $coverage = [];
        if (!empty($parameters)) {
            $coverage = json_decode($parameters['protect_item']);
        }

        // 投保人
        $user = User::join('order', 'order.user_id', '=', 'users.id')
            ->join('cust_rule', 'cust_rule.user_id', '=', 'users.id')
            ->leftJoin('ditch_agent', 'ditch_agent.agent_id', '=', 'cust_rule.agent_id')
            ->leftJoin('ditches', 'ditches.id', '=', 'ditch_agent.ditch_id')
            ->where('users.id', $warranty->user_id)
            ->where('order.status', config('attribute_status.order.payed'))
            ->select(['order.*',
                'ditches.name as ditch_name',
                DB::raw('count(distinct('.DB::getTablePrefix().'order.ty_product_id)) as product_count'),
                DB::raw('sum('.DB::getTablePrefix().'order.premium) as premium'),
                'users.*'
            ])
            ->first();
        $user->premium = $user->premium / 100;
        $user->sex = $this->getSex($user->code);
        $auth_person = AuthenticationPerson::where(['user_id' => $user->id, 'status' => 2])->first();
        if (!empty($auth_person)) {
            $user->verified = 1;
        } else {
            $user->verified = 0;
        }
        // 被保人
        $warranty_recognize = WarrantyRecognizee::where('order_id', $warranty->order_id)->first();
        $warranty_recognize->sex = $this->getSex($warranty_recognize->code);
        // 受益人
//        $warranty_beneficiary = WarrantyBeneficiary::where('id', $warranty->beneficiary_id)->first();
//        $warranty_beneficiary->sex = $this->getSex($warranty_beneficiary->code);

        $item = json_decode($product->json, true);
        $product->category = $item['category']['name'];
        $product->company = $item['company']['name'];
        $product->clauses = $item['clauses'];

        return view('backend_v2.customer.individual.warranty',
            compact('warranty','product', 'user', 'warranty_beneficiary', 'warranty_recognize', 'coverage')
        );
    }

    public function resetPassword(Request $request)
    {
        $password = bcrypt($request->pwd);
        $user = DB::table('users')->where('id', $request->id)->update(['password' => $password]);
        if($user){
            return response()->json(array('status'=> 0,'message'=>'密码重置成功'), 200);
        }
    }

    public function verification($id)
    {
        $user = User::from('users as a')
            ->leftJoin('true_user_info as b', 'a.id', '=', 'b.user_id')
            ->leftJoin('authentication_person as c', 'a.id', '=', 'c.user_id')
            ->where('a.id', $id)
            ->select('a.*', 'b.card_img_front', 'b.card_img_backend', 'b.card_img_person', 'c.status')
            ->first();

        return view('backend_v2.customer.individual.verification', compact('user'));
    }

    public function verificationPost(Request $request)
    {
        if (!$user_id = $request->get('user_id')) {
            return response(['content' => '缺少user_id', 'code' => 1], 400);
        }
        if ((!$type = $request->get('type')) || !in_array($type, ['pass', 'not-pass'])) {
            return response(['content' => '缺少type或者type不正确', 'code' => 2], 400);
        }
        if ($type == 'pass') {
            $type = 2;
        }
        if ($type == 'not-pass') {
            $type = 1;
        }
        $auth = AuthenticationPerson::where('user_id', $user_id)->first();
        if (empty($auth)) {
            AuthenticationPerson::create(['user_id' => $user_id, 'status' => $type]);
        } else {
            if (AuthenticationPerson::where(['user_id' => $user_id, 'status' => '2'])->first()) {
                return response(['content' => '已经审核通过，不能再修改状态', 'code' => 1], 200);
            }
            AuthenticationPerson::where('user_id', $user_id)->update(['status' => $type]);
        }
        return response(['content' => '成功', 'code' => 0], 200);
    }

    public function operation($id)
    {
        $user = User::where(['type' => 'user', 'id' => $id])->first();

        return view('backend_v2.customer.individual.operation', compact('user'));
    }

    protected function getSex($code = null)
    {
        if ($code) {
            return substr($code, (strlen($code) ==15 ? -2 : -2), 1) % 2 ? '男' : '女';
        } else {
            return '';
        }
    }
}
