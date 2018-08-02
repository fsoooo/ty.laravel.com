<?php

namespace App\Http\Controllers\BackendControllers\Customer;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\WarrantyRule;
use Illuminate\Http\Request;
use App\Models\OrderParameter;
use App\Models\WarrantyRecognizee;
use Illuminate\Support\Facades\DB;
use App\Models\AuthenticationPerson;
use App\Models\WarrantyBeneficiary;

class CompanyUserController
{
    public function index()
    {
        $with['order'] = function ($q) {
            $q->with('companyBrokerage')->where('status', config('attribute_status.order.payed'))->select();
        };
        $users = User::with($with)->where('type', 'company')->paginate(15);

        foreach ($users as $user) {
            // 投保次数
            $user->insure_count = $user->order->count(); // 支付成功的订单数
            // 产生保费
            $user->premium = $user->order->sum('premium') / 100; // 支付成功的订单保费累加
            // 佣金
            $brokerage = 0;
            foreach ($user->order as $order) {
                $brokerage += $order->companyBrokerage->brokerage / 100; // 支付成功的订单关联的公司佣金累加
            }
            // 产生佣金
            $user->brokerage = $brokerage;
        }

        return view('backend_v2.customer.company.index', compact('users'));
    }

    public function detail($id)
    {
        $with['order'] = function ($q) {
            $q->where('status', config('attribute_status.order.payed'))->select();
        };
        $select = [
            'authentication.*',
            'users.id',
            'users.name',
            'users.phone',
            'users.email',
            'users.address',
            'users2.name as agent_name'
        ];
        $user = User::with($with)
            ->leftJoin('authentication', 'authentication.user_id', '=', 'users.id')
            ->leftJoin('cust_rule', 'cust_rule.user_id', '=', 'users.id')
            ->leftJoin('agents', 'agents.id', '=', 'cust_rule.agent_id')
            ->leftJoin('users as users2', 'users2.id', '=', 'agents.user_id')
            ->where(['users.type' => 'company', 'users.id' => $id])
            ->select($select)
            ->first();

        $auth_person = AuthenticationPerson::where(['user_id' => $user->id, 'status' => 2])->first();
        if (!empty($auth_person)) {
            $user->verified = 1;
        } else {
            $user->verified = 0;
        }
        // 产生保费
        $user->premium = $user->order->sum('premium') / 100;

        $code = [];
        foreach ($user->order as $order) {
            $recognizee = WarrantyRecognizee::where('order_id', $order->id)->whereNotIn('code', $code)->get();
            $code = array_merge($code, $recognizee->pluck('code')->toArray());
        }
        $user->insured_count = count($code);

        $select = [
            'warranty.warranty_code',
            'warranty.id',
            'order.premium',
            'warranty.status',
            'warranty.start_time',
            'warranty.end_time',
            'order.order_code',
            'order.by_stages_way',
            'order_brokerage.user_earnings',
            'product.product_name',
            'product.json',
            'warranty_recognizee.name as recognizee_name',
            'warranty_policy.name as policy_name',
            DB::raw('sum('.DB::getTablePrefix().'company_brokerage.brokerage) as brokerage'),
        ];
        $lists = Order::with('warranty_recognizee')
            ->where('order.user_id', $id)
            ->join('warranty_rule', 'order.id', '=', 'warranty_rule.order_id')
            ->join('warranty_recognizee', 'order.id', '=', 'warranty_recognizee.order_id')
            ->join('product', 'product.ty_product_id', '=', 'order.ty_product_id')
            ->join('warranty_policy', 'warranty_rule.policy_id', '=', 'warranty_policy.id')
            ->join('warranty', 'warranty.id', '=', 'warranty_rule.warranty_id')
            ->leftJoin('order_brokerage', 'order_brokerage.order_id', '=', 'order.id')
            ->leftJoin('company_brokerage', 'order.id', '=', 'company_brokerage.order_id')
            ->select($select)
            ->paginate(15);

        foreach ($lists as $list) {
            $list->brokerage = $list->brokerage / 100;
            $list->premium = $list->premium / 100;
            $list->user_earnings = $list->user_earnings / 100;
            $parameters = json_decode($list->json, true);
            // 类别
            $list->category = '';
            if (!empty($parameters['category']['name'])) {
                $list->category = $parameters['category']['name'];
            }
            // 公司名
            $list->company = '';
            if (!empty($parameters['company']['name'])) {
                $list->company = $parameters['company']['name'];
            }
            // 购买人数（被保人数）
            $list->insured_count = $list->warranty_recognizee->count();
        }

        //  佣金
        $lists2 = Order::where('status', config('attribute_status.order.payed'))
            ->where('user_id', $id)
            ->where(DB::raw('DATE_FORMAT(pay_time,"%Y")'), date('Y'))
            ->groupBy(DB::raw('DATE_FORMAT(pay_time,"%m")'))
            ->select(
                DB::raw('sum(premium) as premium'),
                DB::raw('DATE_FORMAT(pay_time,"%m") as month')
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
                'premium' => 0
            ];
        }
        array_multisort(array_column($lists2,'month'),SORT_ASC,$lists2);

        // 保费
        $lists3 = Order::join('company_brokerage', 'order.id', '=', 'company_brokerage.order_id')
            ->where('order.status', config('attribute_status.order.payed'))
            ->where('order.user_id', $id)
            ->where(DB::raw('DATE_FORMAT('.DB::getTablePrefix().'order.pay_time,"%Y")'), date('Y'))
            ->groupBy(DB::raw('DATE_FORMAT('.DB::getTablePrefix().'order.pay_time,"%m")'))
            ->select(
                DB::raw('sum('.DB::getTablePrefix().'company_brokerage.brokerage) as brokerage'),
                DB::raw('DATE_FORMAT('.DB::getTablePrefix().'order.pay_time,"%m") as month')
            )
            ->get()->toArray();

        $result1_month = [];
        foreach ($lists3 as $key => $item) {
            $result1_month[] = (int)$item['month'];
        }
        $month = range(1, 12);
        $diff_month = array_diff($month, $result1_month);
        foreach ($diff_month as $item) {
            $lists3[] = [
                'month' => $item,
                'brokerage' => 0
            ];
        }
        array_multisort(array_column($lists3,'month'),SORT_ASC,$lists3);


        return view('backend_v2.customer.company.detail', compact('user', 'lists', 'lists2', 'lists3'));
    }

    public function insurance($id)
    {
        $user = User::where(['type' => 'company', 'id' => $id])->first();
        // 投保产品列表
        $select = [
            'warranty.warranty_code',
            'warranty.start_time',
            'warranty.end_time',
            'warranty.status',
            'order.premium',
            'warranty.id',
            'order.pay_time',
            'order.order_code',
            'order.pay_time',
            'order.by_stages_way',
            'product.json',
            'product.product_name',
            'warranty_recognizee.name as recognizee_name',
            'warranty_policy.name as policy_name',
            'order_brokerage.user_earnings',
            DB::raw('sum('.DB::getTablePrefix().'company_brokerage.brokerage) as brokerage'),
            'users2.name as agent_name'
        ];
        $lists = Order::where('order.user_id', $id)
            ->join('warranty_rule', 'order.id', '=', 'warranty_rule.order_id')
            ->join('warranty_recognizee', 'order.id', '=', 'warranty_recognizee.order_id')
            ->join('product', 'product.ty_product_id', '=', 'order.ty_product_id')
            ->join('warranty_policy', 'warranty_rule.policy_id', '=', 'warranty_policy.id')
            ->join('warranty', 'warranty_rule.warranty_id', '=', 'warranty.id')
            ->join('order_brokerage', 'order_brokerage.order_id', '=', 'order.id')
            ->join('company_brokerage', 'order.id', '=', 'company_brokerage.order_id')
            ->join('agents', 'agents.id', '=', 'order.agent_id')
            ->join('users as users2', 'users2.id', '=', 'agents.user_id')
            ->select($select)
            ->paginate(15);

        foreach ($lists as $list) {
            $list->brokerage = $list->brokerage / 100;
            $list->premium = $list->premium / 100;
            $list->user_earnings = $list->user_earnings / 100;
            $parameters = json_decode($list->json, true);
            // 公司名
            $list->company = '';
            if (!empty($parameters['company']['name'])) {
                $list->company = $parameters['company']['name'];
            }
        }

        return view('backend_v2.customer.company.insurance', compact('user', 'lists'));
    }

    public function warranty($id)
    {
        $select = [
            'warranty.warranty_code',
            'warranty.start_time',
            'warranty.end_time',
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
            'warranty_rule.order_id',
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
                'users.name'
            ])
            ->first();

        $user->premium = $user->premium / 100;

        // 被保人
        $warranty_recognize = WarrantyRecognizee::where('order_id', $warranty->order_id)->paginate(10);

        // 受益人
        $warranty_beneficiary = WarrantyBeneficiary::where('id', $warranty->beneficiary_id)->first();

        $item = json_decode($product->json, true);
        $product->category = $item['category']['name'];
        $product->company = $item['company']['name'];
        $product->clauses = $item['clauses'];

        return view('backend_v2.customer.company.warranty',
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
            ->leftJoin('true_firm_info as b', 'a.id', '=', 'b.user_id')
            ->leftJoin('authentication as c', 'a.id', '=', 'c.user_id')
            ->where('a.id', $id)
            ->select('a.*', 'b.card_img_front', 'b.card_img_backend', 'b.license_img', 'c.status')
            ->first();

        return view('backend_v2.customer.company.verification', compact('user'));
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
            AuthenticationPerson::where('user_id', $user_id)->update(['status' => $type]);
        }
        return response(['content' => '操作成功', 'code' => 0], 200);
    }

    public function operation($id)
    {
        $user = User::where(['type' => 'company', 'id' => $id])->first();
        return view('backend_v2.customer.company.operation', compact('user'));
    }
}
