<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsController extends Controller
{
    //

    public function sendEmail()
    {
        $email = $_POST['email'];
        $title = $_POST['title'];
        $content = $_POST['content'];dd($content);
        $send = $_POST['send_id'];
        $sign_help = new RsaSignHelp();
        $biz_content = array('email'=>$email,'title'=>$title,
            'send'=>$send,'content'=>$content);
        $biz_content = strrev($sign_help->base64url_encode(json_encode($biz_content)));
//                var_dump($biz_content);
        $data['account_id'] = '201706091525281604';
        $data['timestamp'] = time();
        $data['biz_content'] = $biz_content;
        krsort($data);
        $data['sign'] = md5($sign_help->base64url_encode(json_encode($data)) . 'b09204fb62be228eb2dad2e58392facf');
        $response = Curl::to(env('TY_API_PRODUCT_SERVICE_URL').'public/api/sendemails')
            ->returnResponseObject()
            ->withData($data)
            // ->asJson()
            ->post();
        $status = $response->status;
        $content = $response->content;
        if($status == '200'){
            return $content;
        }
    }
}
