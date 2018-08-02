<?php

use Illuminate\Database\Seeder;
use App\Models\SmsModel;

class SmsModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sms_models')->insert([
            array('model_id'=>'62524','model_name'=>'注册验证','content'=>'感谢您的注册，本次注册验证码为{1}，请于3分钟内正确输入，切勿泄露他人。','status'=>'1'),
            array('model_id'=>'62523','model_name'=>'重置密码','content'=>'尊敬的用户，您正在申请重置密码，验证码为{1}，请勿向任何单位或个人泄露此验证码。','status'=>'1'),
            array('model_id'=>'62526','model_name'=>'申请通过','content'=>'尊敬的{1}先生/女士，您在我们平台上{2}的申请已通过，请登录平台-我的申请，查看申请记录。','status'=>'1'),
            array('model_id'=>'62529','model_name'=>'申请过期','content'=>'尊敬的{1}先生/女士，您在我们平台上{2}的申请已过期，请登录平台-我的申请，查看申请记录。','status'=>'1'),
            array('model_id'=>'62508','model_name'=>'受理成功','content'=>'尊敬的{1}先生/女士：您上传的理赔案件我们已于{2}收到并查验完毕，与您上传的内容一致，我们已开始受理，请您随时关注网站名称公众号了解理赔进度，或拨打客户服务热线400-886-2309进行咨询。','status'=>'1'),
            array('model_id'=>'62509','model_name'=>'账户失效','content'=>'尊敬的{1}先生/女士，您好！您参加的我们网站的{2}活动，因未及时录入保障人员信息，保障申请及账户将在24小时后自动失效，如有疑问请联系客服400-886-2309。','status'=>'1'),
            array('model_id'=>'52339','model_name'=>'操作验证','content'=>'尊敬的用户，您本次的验证码为：{1}，3分钟内有效。如非本人操作请忽略本信息。','status'=>'1'),
            array('model_id'=>'107973','model_name'=>'登录验证','content'=>'亲爱的用户，您正在使用手机号快捷登录，验证码为{1}，请于3分钟内正确输入，请勿向任何单位或个人泄露。','status'=>'1'),
            array('model_id'=>'109489','model_name'=>'密码找回','content'=>'亲爱的用户，您正在申请找回密码，验证码为{1}，请于3分钟内正确输入，请勿向任何单位或个人泄露。','status'=>'1'),
            array('model_id'=>'134321','model_name'=>'业管密码重置','content'=>'尊敬的{1}用户，您的重置密码申请已审核通过，您的新密码是{2}，切勿泄露他人，请及时登录查看。','status'=>'1'),

        ]);
    }
}
