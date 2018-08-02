<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/26
 * Time: 10:27
 */

namespace App\Http\Controllers\BackendControllers;
use App\Models\Order;
use App\Models\SmsInfo;
use App\Helper\MakeSign;
use App\Helper\Ucpaas;
use App\Models\SmsModel;
use App\Helper\Email;
use App\Http\Controllers\backendControllers\BaseController;
use App\Models\Claim;
use App\Models\ClaimRule;
use App\Models\ClaimUrl;
use App\Models\Status;
use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use Request;
use App\Models\ClaimRecord;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
class ClaimManagementController extends BaseController{

    //显示理赔页面
    public function index()
    {
        return view('backend_v2.claim.index');
    }

    public function claimDetails()
    {
        return view('backend_v2.claim.claim_details');
    }
}