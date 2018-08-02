<?php
/**
 * Created by PhpStorm.
 * User: xyn
 * Date: 2017/8/18
 * Time: 14:47
 */

namespace App\Http\Controllers\BackendControllers;

use App\Models\ApiInfo;
use App\Helper\RsaSignHelp;
use Illuminate\Http\Request;
use App\Models\OrderPrepareParameter;

class InsOrderController
{
    protected $_request;
    protected $_signHelp;

    public function __construct(Request $request)
    {
        $this->_request = $request;
        $this->_signHelp = new RsaSignHelp();
    }

    /**
     * 预购订单
     */
    public function prepareOrder()
    {
        //todo
        $input = $this->_request->all();
        unset($input['_token']);
        $agent_id = $input['agent_id'];
        $ditch_id = $input['ditch_id'];
        $date = date('Ymd',time());

        $random = rand(0,9999999);
        $random_number = substr('0000000'.$random,-7);
        $identification = ($date.$random_number);   //预购订单号

        $parameter = json_encode($input);
        $order_prepare_parameter = new OrderPrepareParameter();
        $order_prepare_parameter->agent_id = $agent_id;
        $order_prepare_parameter->ditch_id = $ditch_id;
        $order_prepare_parameter->identification = $identification;
        $order_prepare_parameter->parameter = $parameter;
        $order_prepare_parameter->private_p_code = $input['private_p_code'];

        if($order_prepare_parameter->save()){
            //预存成功,跳转到完善信息页面
            setcookie('identification',$identification,time()+3600,'/');

            return view('frontend.guests.product.covernotes')
                ->with('identification',$identification);
        }else{
            return back()->withErrors('出错了，请重新尝试');
        }
    }
}