<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComChannel extends Migration
{
    /**
     * Run the migrations.
     *渠道相关的数据库迁移
     * @return void
     */
    public function up()
    {
        //渠道详情表
        Schema::create('channel', function (Blueprint $table) {
            $table->integer('id')->comment('channel_id');
            $table->string('name')->comment('公司名称');
            $table->string('email')->comment('公司邮箱');
            $table->string('url')->comment('公司url');
            $table->string('code')->comment('公司唯一代号');
            $table->text('describe')->comment('描述');
            $table->string('only_id')->comment('唯一标识ID');
            $table->string('sign_key')->comment('秘钥KEY');
            $table->string('ip')->comment('ip')->nullable();
            $table->string('address')->comment('地址')->nullable();
            $table->integer('status')->comment('状态')->default(0);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        //预投保信息表
        Schema::create('channel_prepare_info', function (Blueprint $table) {
            $table->string('channel_user_name')->comment('用户姓名');
            $table->string('channel_user_type')->comment('证件类型')->default(null);
            $table->string('channel_user_code')->comment('证件号');
            $table->string('channel_user_phone')->comment('手机号');
            $table->string('channel_user_email')->comment('邮箱')->default(null);
            $table->string('channel_user_address')->comment('地址')->default(null);
            $table->string('channel_bank_name')->comment('银行名称')->default(null);
            $table->string('channel_bank_address')->comment('开户行地址')->default(null);
            $table->string('channel_bank_code')->comment('银行卡号')->default(null);
            $table->string('channel_bank_phone')->comment('银行预留电话')->default(null);
            $table->string('channel_provinces')->comment('投保地区（省）')->default(null);
            $table->string('channel_city')->comment('投保地区（市）')->default(null);
            $table->string('channel_county')->comment('投保地区（县）')->default(null);
            $table->string('courier_state')->comment('站点地址')->default(null);
            $table->string('courier_start_time')->comment('分拣时间')->default(null);
            $table->string('channel_back_url')->comment('回调地址')->default(null);
            $table->string('channel_account_id')->comment('渠道账户ID')->default(null);
            $table->string('channel_code')->comment('渠道标识')->default(null);
            $table->string('operate_code')->comment('操作标识')->default(null);
            $table->string('operate_time')->comment('操作时间');
            $table->string('p_code')->comment('产品标识')->default(null);
            $table->string('is_insure')->comment('是否投保')->default(null);
            $table->timestamps();
        });
        //预投保历史表
        Schema::create('channel_old_info', function (Blueprint $table) {
            $table->string('channel_user_name')->comment('用户姓名')->default(null);
            $table->string('channel_user_type')->comment('证件类型')->default(null);
            $table->string('channel_user_code')->comment('证件号')->default(null);
            $table->string('channel_user_phone')->comment('手机号')->default(null);
            $table->string('channel_user_email')->comment('邮箱')->default(null);
            $table->string('channel_user_address')->comment('地址')->default(null);
            $table->string('channel_bank_name')->comment('银行名称')->default(null);
            $table->string('channel_bank_address')->comment('开户行地址')->default(null);
            $table->string('channel_bank_code')->comment('银行卡号')->default(null);
            $table->string('channel_bank_phone')->comment('银行预留电话')->default(null);
            $table->string('channel_provinces')->comment('投保地区（省）')->default(null);
            $table->string('channel_city')->comment('投保地区（市）')->default(null);
            $table->string('channel_county')->comment('投保地区（县）')->default(null);
            $table->string('courier_state')->comment('站点地址')->default(null);
            $table->string('courier_start_time')->comment('分拣时间')->default(null);
            $table->string('channel_back_url')->comment('回调地址')->default(null);
            $table->string('channel_account_id')->comment('渠道账户ID')->default(null);
            $table->string('channel_code')->comment('渠道标识')->default(null);
            $table->string('operate_code')->comment('操作标识')->default(null);
            $table->string('p_code')->comment('产品标识')->default(null);
            $table->string('is_insure')->comment('是否投保')->default(null);
            $table->string('order_id')->comment('订单关联表')->default(null);
            $table->string('proposal_num')->comment('投保单号')->default(null);
            $table->string('prepare_status')->comment('核保状态')->default(null);
            $table->string('prepare_content')->comment('核保备注')->default(null);
            $table->string('pay_status')->comment('支付状态')->default(null);
            $table->string('pay_content')->comment('支付备注')->default(null);
            $table->string('issue_status')->comment('出单状态')->default(null);
            $table->string('issue_content')->comment('出单备注')->default(null);
            $table->string('claim_status')->comment('理赔状态')->default(null);
            $table->string('claim_content')->comment('理赔备注')->default(null);
            $table->string('operate_time')->comment('操作执行时间')->default(null);
            $table->timestamps();
        });
        //预投保操作表
        Schema::create('channel_operate', function (Blueprint $table) {
            $table->string('channel_user_code')->comment('证件号，与渠道预投保表关联')->default(null);
            $table->string('order_id')->comment('订单关联表')->default(null);
            $table->string('proposal_num')->comment('投保单号')->default(null);
            $table->string('prepare_status')->comment('核保状态')->default(null);
            $table->string('prepare_content')->comment('核保备注')->default(null);
            $table->string('pay_status')->comment('支付状态')->default(null);
            $table->string('pay_content')->comment('支付备注')->default(null);
            $table->string('issue_status')->comment('出单状态')->default(null);
            $table->string('issue_content')->comment('出单备注')->default(null);
            $table->string('claim_status')->comment('理赔状态')->default(null);
            $table->string('claim_content')->comment('理赔备注')->default(null);
            $table->string('init_status')->comment('初始化状态')->default(null);
            $table->string('init_content')->comment('初始化备注')->default(null);
            $table->string('operate_time')->comment('操作执行时间')->default(null);
            $table->timestamps();
        });
        //预投保操作表
        Schema::create('channel_claim_apply', function (Blueprint $table) {
            $table->string('channel_user_code')->comment('证件号，与渠道预投保表关联')->default(null);
            $table->string('union_order_code')->comment('订单关联表')->default(null);
            $table->string('warranty_code')->comment('投保单号')->default(null);
            $table->string('user_report_info')->comment('用户报案信息');
            $table->string('user_report_status')->comment('用户报案状态');
            $table->string('user_report_content')->comment('用户报案返回信息')->default(null);
            $table->longText('cid_files')->comment('用户身份资料')->default(null);
            $table->longText('bank_files')->comment('收款银行资料')->default(null);
            $table->longText('claim_materials')->comment('理赔资料')->default(null);
            $table->longText('add_push_files')->comment('补充资料')->default(null);
            $table->string('claim_add_status')->comment('理赔材料状态,是否需要补充材料')->default(null);
            $table->string('claim_start_time')->comment('理赔报案时间')->nullable();
            $table->string('claim_start_status')->comment('理赔报案状态,是否成功')->nullable();
            $table->timestamps();
        });

        //预投保信息表
        Schema::create('channel_insure_info', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('user_id')->nullable()->comment('用户ID,和用户关联');
            $table->string('channel_user_name')->comment('用户姓名');
            $table->string('channel_code_type')->comment('证件类型');
            $table->string('channel_user_code')->comment('证件号');
            $table->string('channel_user_phone')->comment('手机号');
            $table->string('insure_start_time')->comment('起保时间');
            $table->string('insure_end_time')->comment('截至时间');
            $table->string('channel_user_sex')->nullable()->comment('性别');
            $table->string('channel_user_age')->nullable()->comment('年龄');
            $table->string('channel_user_birthday')->nullable()->comment('生日');
            $table->string('channel_nationality')->nullable()->comment('护照国籍');
            $table->string('occupation')->nullable()->comment('职业');
            $table->string('channel_code')->comment('渠道标识');
            $table->string('insure_status')->comment('投保状态')->default('0');
            $table->timestamps();
        });


        //微信代扣签约信息表contract
        Schema::create('channel_contract_info', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('operate_time')->comment('操作时间');
            $table->string('request_serial')->comment('请求序列号');
            $table->string('contract_expired_time')->comment('协议过期时间');
            $table->string('contract_id')->comment('委托代扣协议id');
            $table->string('change_type')->comment('变更类型');
            $table->string('contract_code')->comment('签约协议号');
            $table->string('openid')->comment('微信openID');
            $table->string('channel_user_code')->comment('证件号');
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //渠道详情表
        Schema::dropIfExists('channel');
        //预投保信息表
        Schema::dropIfExists('channel_prepare_info');
        //渠道历史表
        Schema::dropIfExists('channel_old_info');
        //渠道操作表
        Schema::dropIfExists('channel_operate');
        //渠道理赔操作表
        Schema::dropIfExists('channel_claim_apply');
        //渠道投保信息存储表
        Schema::dropIfExists('channel_insure_info');
        //微信代扣签约信息表contract
        Schema::dropIfExists('channel_contract_info');
    }
}
