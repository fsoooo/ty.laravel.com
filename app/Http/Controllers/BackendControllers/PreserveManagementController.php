<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/26
 * Time: 10:27
 */

namespace App\Http\Controllers\BackendControllers;
use App\Helper\MakeSign;
use App\Helper\Ucpaas;
use App\Helper\Email;
use App\Http\Controllers\backendControllers\BaseController;
use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use Request;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
class PreserveManagementController extends BaseController{

    //显示保全页面
    public function index()
    {
        return view("backend_v2.preserve.index");
    }

    //显示保全页面
    public function preserveDetails()
    {
        return view("backend_v2.preserve.preserve_details");
    }
}