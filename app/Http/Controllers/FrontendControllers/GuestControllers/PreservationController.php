<?php
/**
 * Created by PhpStorm.
 * User: wangsl
 * Date: 2017/12/12
 * Time: 11:32
 */
namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\WarrantyRelation;
use App\Helper\Issue;
use App\Http\Controllers\ApiControllers\InsApiController;
use App\Models\AddRecoginzee;
use App\Models\CancelWarrantyRecord;
use App\Models\CardType;
use App\Models\CodeType;
use App\Models\FormInfo;
use App\Models\MaintenanceRecord;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Warranty;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use App\Models\WarrantyRule;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Bank;
use App\Models\Occupation;
use App\Models\Relation;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
use App\Models\MaintenanceInfo;
use Request,Validator;
use Request as Requests;

class PreservationController extends BaseController
{
    protected $_request;
    protected $_signHelp;

    /**
     * 初始化
     *
     */
    public function __construct(Request $request)
    {
        $this->uid = $this->getId();
        $this->_signHelp = new RsaSignHelp();
    }

    /**
     * 退保操作
     * @return string
     */
    public function insureCacel($warranty_code)
    {
        //TODO  没有做状态判断
        $warranty_res = Warranty::where('warranty_code',$warranty_code)
            ->with('warranty_rule.policy','warranty_rule.order')
            ->first();
        $pay_res = json_decode($warranty_res['warranty_rule']['order']['pay_account'],true);
        $data = [];
        $data['private_p_code'] = $warranty_res['warranty_rule']['private_p_code'];
        $data['union_order_code'] = $warranty_res['warranty_rule']['union_order_code'];
        $data['warranty_code'] = $warranty_code;
        $data['bank_uuid'] = $pay_res['bank_uuid'];
        $data['bank_code'] = $pay_res['bank_code'];
        $data['bank_number'] = $pay_res['bank_number'];
        $data['premium'] = $pay_res['premium'];
        $data['apply_user_name'] = $warranty_res['warranty_rule']['policy']['name'];
        $data['apply_user_code'] = $warranty_res['warranty_rule']['policy']['code'];
        $data = $this->_signHelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/cacel')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(600)
            ->post();
         print_r($response->content);die;

    }
}
