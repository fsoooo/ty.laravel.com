<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\EmailInfo;
use App\Models\SmsModel;
use App\Models\SmsInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inter;
use Illuminate\Support\Facades\DB;
use App\Helper\Email;
use App\Helper\RsaSignHelp;
use Illuminate\Support\Facades\Session;
use Ixudra\Curl\Facades\Curl;
use App\Helper\Uploader;

class InterfacesController extends Controller
{

    //接口处理
    public function passService()
    {
        $company = env('TY_API_ID');
//        $sign_help = new RsaSignHelp();
//        $biz_content = array('company',$company);
//        $data = $sign_help->tySign($biz_content);
//        $response = Curl::to(env('TY_API_SERVICE_URL') . '/saveemails')
//            ->returnResponseObject()
//            ->withData($data)
//            ->withTimeout(60)
//            ->post();
        $response = '{"status":"true","token":"f7da7ba7e0eadbe8ea01d418b93c32"}';
        $response = json_decode($response, true);
        $status = $response['status'];
        if ($status) {
            $token = $response['token'];
            $check_token = Inter::where('token', $token)->first();
            if (is_null($check_token)) {
                $res = Inter::insert([
                    'company_id' => $company,
                    'token' => $token,
                    'status' => '1'
                ]);
                if ($res) {
                    return (['status' => 0, 'message' => '操作成功！']);
                } else {
                    return (['status' => 1, 'message' => '操作失败！']);
                }
            } else {
                return (['status' => 1, 'message' => '错误！']);
            }

        } else {
            return (['status' => 1, 'message' => '无服务！']);
        }


    }

    public function  emailFilesSend(){
        $uploader = new Uploader();
        $data = $uploader->upload($_FILES['file'], array(
            'limit' => 5, //Maximum Limit of files. {null, Number}
            'maxSize' => 2, //Maximum Size of files {null, Number(in MB's)}
            'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
            'required' => false, //Minimum one file is required for upload {Boolean}
            'uploadDir' => 'upload/', //Upload directory {String}
            'title' => array('auto', 10), //New file name {null, String, Array} *please read documentation in README.md
            'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
            'replace' => false, //Replace the file if it already exists  {Boolean}
            'perms' => null, //Uploaded file permisions {null, Number}
            'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
            'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
            'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
            'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
            'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
            'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
        ));
        if($data['isComplete']){
            $files = $data['data'];
            return (['status' => true, 'message' => $files['files']]);
        }
        if($data['hasErrors']){
            $errors = $data['errors'];
            return $errors;
        }
        function onFilesRemoveCallback($removed_files){
            foreach($removed_files as $key=>$value){
                $file = '../upload/' . $value;
                if(file_exists($file)){
                    unlink($file);
                }
            }
            return $removed_files;
        }
    }



    //发送邮件
    public function sendEmails()
    {
        $email = $_POST['email'];
        $emails = explode("；", $email);
        $title = $_POST['title'];
        $content = $_POST['content'];
        if(empty($email)||empty($title)||empty($content)){
            return (['status'=>'1','message'=>'请输入邮件内容！！']);
        }
        $send = env('TY_API_ID');
        $file = $_POST['file'];

        if(!empty($file)){
            $file = $file[0];
        }
        $mail = new Email();
        $mail->setServer("smtp.exmail.qq.com", "galaxy@mengtiancai.com", "Shiqu521"); //设置smtp服务器
        $mail->setFrom("galaxy@mengtiancai.com"); //设置发件人
        $mail->setReceiver($emails);
        if(empty($file)){
            $mail->setMailInfo($title,$content);// 设置邮件主题、内容
        }else{
            $mail->setMailInfo($title,$content,$file);// 设置邮件主题、内容、附件
        }
        $success =  $mail->sendMail(); //发送
        $success = true;
        if($success){

            EmailInfo::insert([
                'send'=>$send,
                'receive'=>$email,
                'title'=>$title,
                'content'=>$content,
                'file'=>$file,
                'created_at'=>date('YmdHis',time()),
                'updated_at'=>date('YmdHis',time())
            ]);
            $url = $_GET['url'];
            $biz_content = array('email'=>$email,'title'=>$title,
                'send'=>$send,'content'=>$content,'file'=>$url.'/'.$file);
            $sign_help = new RsaSignHelp();
            $data = $sign_help->tySign($biz_content);
            $response = Curl::to(env('TY_API_SERVICE_URL') . '/saveemails')
                ->returnResponseObject()
                ->withData($data)
                ->withTimeout(60)
                ->post();
            if($response->status == '200'){
                return (['status' => 0, 'message' => '操作成功！']);
            }
            return (['status' => 0, 'message' => '邮件发送成功！']);
        }else{
            return (['status' => 1, 'message' => '操作失败！']);
        }

    }

    //发邮件
    public function companySendEmail(Request $request)
    {
        $input = $request->all();
        $title = '天眼互联注册验证码';
        $code = rand(1000,9999);
        $content = "<p>尊敬的客户</p><p>您好</p><p>请输入以下的验证码：</p>
                    <p>".$code."</p>"."<p>天眼互联</p>";
        $mail = new Email();
        $mail->setServer("smtp.exmail.qq.com", "galaxy@mengtiancai.com", "Shiqu521"); //设置smtp服务器
        $mail->setFrom("galaxy@mengtiancai.com"); //设置发件人
        $mail->setReceiver($input['email']);
        $mail->setMailInfo($title,$content);// 设置邮件主题、内容
        $success =  $mail->sendMail(); //发送
        if($success){
            Session([$input['email']=>$code]);
            return (['status'=>'0','message'=>'发送成功']);
        }else{
            return (['status'=>'1','message'=>'发送出现故障']);
        }
    }

    //发短信
    public function sendSms(Request $request)
    {
            $input = $request->all();
            $token = !empty($input['token']) ? $input['token'] : 1;
            $company = env('TY_API_ID', '123456789');
            $sms_content = !empty($input['sms_content']) ? $input['sms_content'] : null;
            $phone = $input['phone'];
            if(\Cache::has("reg_code_".$phone)){
                return (json_encode(['status'=>'2','message'=>'短信五分钟有效'],JSON_UNESCAPED_UNICODE));
            }
            $user_name = isset($input['name']) ? $input['name'] : $phone;
            $model = $input['model'];
            if(empty($phone)||empty($model)){
                return (['status'=>'1','message'=>'请输入短信内容！！']);
            }
                $time =  !empty($input['time']) ? $input['time'] : date("Y-m-d H:i:s");//时间插件获取的时间，字符串类型
                $models = SmsModel::where('model_id',$model)->first();
                $model_id = $models['model_id'];
        if($model=='52339'||$model=='62523'||$model=='62524'||$model=='107973'||$model=='109489'){
                //随机验证码
                $b = '123456789';
                $b = str_shuffle($b);
                $rand = substr($b,0,6);
            }else if($model_id=='62526'||$model_id=='62529'){
            //申请通知
                $rand = array($sms_content);
            }elseif($model_id=='62508'){
                //受理通知
                $rand = array($sms_content);
            }elseif($model_id=='62509'){
                //账户失效
                $rand = array($sms_content);
            }elseif($model=='134321'){
                //重置密码
                $rand = array([[$sms_content,$user_name]]);
//                var_dump($sms_content);die;
            }
            $model = $input['model'];

            $biz_content = array('company'=>$company,'token'=>$token,'phone'=>$phone,
                'model'=>$model,'sms_content'=>$sms_content,'time'=>$time,'rand'=>$rand);
            $sign_help = new RsaSignHelp();
            $url = config('view_url.app_url')."/dosms";
            $data = $sign_help->tySign($biz_content);
            $response = Curl::to($url)
                ->returnResponseObject()
                ->withData($data)
                ->withTimeout(60)
                ->post();
            $contents = $response->content;
            $status = $response->status;
            if($status == '200' ){
                //验证码存缓存
                $expiresAt = \Carbon\Carbon::now()->addMinutes(10);
                \Cache::put("reg_code_".$phone, $rand, $expiresAt);
                $model_content = $models->content;
                if(is_array($rand)){
                    foreach ($rand as $value){
                        foreach ($value as $v){
                            if(is_array($v)){
                                $a = str_replace("{2}",$v[0],$model_content);
                                $content = str_replace("{1}",$v[1],$a);
                            }else{
                                $content=  preg_replace('/(?:\{)(.*)(?:\})/i',$v,$model_content);
                            }
                        }
                    }
                    $res = SmsInfo::insert([
                        'company_id'=>$company,
                        'content'=>$content,
                        'send_phone'=>$phone,
                        'created_at'=>date('Y-m-d H:i:s',time()),
                        'updated_at'=>date('Y-m-d H:i:s',time())
                    ]);

                }else{
                    $content=  preg_replace('/(?:\{)(.*)(?:\})/i',$rand,$model_content ,1);
                    $res = SmsInfo::insert([
                        'company_id'=>$company,
                        'content'=>$content,
                        'send_phone'=>$phone,
                        'created_at'=>date('Y-m-d H:i:s',time()),
                        'updated_at'=>date('Y-m-d H:i:s',time())
                    ]);
                }
                $contents =  json_decode($contents,true);
                return $contents;
            }else{
                return (json_encode(['status'=>'1','message'=>'短信发送出现故障！！'],JSON_UNESCAPED_UNICODE));
            }

    }




    public function  emailsFileSend(){
        $uploader = new Uploader();
        $data = $uploader->upload($_FILES['file'], array(
            'limit' => 10, //Maximum Limit of files. {null, Number}
            'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
            'extensions' => array('zip'), //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
            'required' => false, //Minimum one file is required for upload {Boolean}
            'uploadDir' => 'upload/', //Upload directory {String}
            'title' => array('auto', 10), //New file name {null, String, Array} *please read documentation in README.md
            'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
            'replace' => false, //Replace the file if it already exists  {Boolean}
            'perms' => null, //Uploaded file permisions {null, Number}
            'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
            'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
            'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
            'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
            'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
            'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
        ));
        if($data['isComplete']){
            $files = $data['data'];
            return (['status' => true, 'message' => $files['files']]);
        }
        if($data['hasErrors']){
            $errors = $data['errors'];
            return $errors;
        }
        function onFilesRemoveCallback($removed_files){
            foreach($removed_files as $key=>$value){
                $file = '../upload/' . $value;
                if(file_exists($file)){
                    unlink($file);
                }
            }
            return $removed_files;
        }
    }
    //邮箱发送
    public function emailsSend(){

        $email = $_GET['email'];
        $emails = explode("；", $email);
        $title = $_GET['title'];
        $content = $_GET['content'];
        $file = $_GET['file'];
        if(empty($email)||empty($title)||empty($content)){
            return (['status'=>'1','message'=>'请输入邮箱内容！！']);
        }
        $mail = new Email();
        $mail->setServer("smtp.exmail.qq.com", "ghj@douweixiao.cn", "1234Aa"); //设置smtp服务器
        $mail->setFrom("ghj@douweixiao.cn"); //设置发件人
        //设置收件人，多个收件人，调用多次
        $mail->setReceiver($emails);
        if(empty($file)){
            $mail->setMailInfo($title,$content);// 设置邮件主题、内容
        }else{
            $mail->setMailInfo($title,$content,$file);// 设置邮件主题、内容、附件
        }
        $success =  $mail->sendMail(); //发送
        if($success){
            return (['status' => 0, 'message' => '操作成功！！']);
        }else{
            return (['status' => 1, 'message' => '操作失败！！']);
        }

    }

}
