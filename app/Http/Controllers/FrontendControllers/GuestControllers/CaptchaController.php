<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Http\Controllers\FrontendControllers\BaseController;

use App\Models\NodeCondition;
use App\Models\Order;
use App\Models\User;
use Request,Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Claim;
use App\Models\ClaimRule;
use App\Models\ClaimRecord;
use App\Models\ClaimUrl;
use App\Models\Warranty;
use App\Models\WarrantyRule;
use App\Helper\Status;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
use Gregwar\Captcha\CaptchaBuilder;
class CaptchaController extends BaseController
{
    /**
     * 验证码生成
     * @param  [type] $tmp [description]
     * @return [type]      [description]
     */
    public function captcha($tmp)
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        Session::flash('milkcaptcha', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }
    public function checkImagegCode(Request $request){
        $code = $_GET['img_code'];
        if($code==''||$code==null){
            return (['status'=>'2','msg'=>'请正确输入验证码']);
        }
        if(Session::get('milkcaptcha')!=$code) {
            return (['status'=>'1','msg'=>'验证码错误']);
        }else{
            return (['status'=>'0','msg'=>'验证码正确']);
        }
    }

}