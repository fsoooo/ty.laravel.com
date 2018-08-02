<?php

/**
 * 悟空保接口
 */

namespace App\Http\Controllers\FrontendControllers;

use App\Helper\Issue;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
//use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\WarrantyRule;

class QxTestController extends BaseController
{
    protected $signHelp;

    public function __construct()
    {
        $this->signHelp = new RsaSignHelp();
    }

    /**
     * 算费接口
     */
    public function quote()
    {

    }

    /**
     * 投保
     */
    public function buyIns()
    {

    }

    /**
     * 核保
     */
    public function checkIns()
    {

    }

    /**
     * 支付
     */
    public function payIns()
    {

    }

    /**
     * 出单
     */
    public function issue()
    {

    }

}