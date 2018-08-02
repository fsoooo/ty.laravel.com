<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('order_code')->comment('订单编号');
            $table->integer('relation_order_id')->comment('关联的订单id')->default(0);
            $table->integer('user_id')->comment('客户的id');
            $table->integer('is_settlement')->default('1')->nullable()->comment('用来判断订单佣金是否结算，1表示已经结算，0表示未结算');
            $table->integer('competition_id')->default(0)->comment('对应的活动id，直接结算则不需要填写');
            $table->integer('agent_id')->comment('代理的id,为空则为用户自主购买')->default(0)->nullable();
            $table->integer('ditch_id')->comment('渠道的id,为空则为用户自主购买')->default(0)->nullable();
            $table->integer('plan_id')->comment('计划书id,为空则为用户自主购买')->default(0)->nullable();
            $table->integer('ty_product_id')->comment('产品id')->nullable();
            $table->string('private_p_code')->comment('内部产品唯一码')->nullable();
            $table->string('by_stages_way')->comment('缴费分期方式')->nullable();
//            $table->string('product_number')->comment('产品的唯一码');
            $table->timestamp('pay_time')->comment('支付时间')->nullable();
            $table->enum('claim_type', ['online','offline'])->comment('理赔类型');
            $table->integer('deal_type')->comment('成交类型，0表示线上成交，1表示线下成交');
            $table->integer('premium')->comment('订单价格')->nullable();
            $table->timestamp('start_time')->comment('开始时间')->nullable();
            $table->timestamp('end_time')->comment('结束时间')->nullable();
            $table->integer('status')->comment('状态')->default(0);
            $table->string('pay_way')->comment('支付类型');
            $table->string('pay_account')->comment('支付账户：银行卡号等')->nullable();
            $table->string('check_error_message')->comment('核保错误信息')->nullable();
            $table->string('pay_error_message')->comment('支付错误信息')->nullable();
            $table->string('reject_error_message')->comment('支付错误信息')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });


        //订单预备参数表
        Schema::create('order_prepare_parameter', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->longText('parameter')->comment('投保参数');
            $table->integer('ty_product_id')->comment('ty产品id')->nullable();
            $table->string('private_p_code')->comment('内部产品唯一码')->nullable();
            $table->integer('agent_id')->comment('代理人id')->nullable();
            $table->integer('ditch_id')->comment('渠道id')->nullable();
            $table->integer('plan_id')->comment('计划书id')->nullable();
            $table->integer('user_id')->comment('创建用户的id');
            $table->string('identification',18)->unique()->comment('唯一标识');
            $table->string('union_order_code')->comment('订单号')->default(null);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //订单参数表
        Schema::create('order_parameter', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->longText('parameter')->comment('投保参数');
            $table->integer('ty_product_id')->comment('ty产品id')->nullable();
            $table->string('private_p_code')->comment('内部产品唯一码')->nullable();
            $table->integer('order_id')->comment('对应的订单编号');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //订单关系
        Schema::create('warranty_rule', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->integer('order_id')->comment('订单id');
            $table->integer('parameter_id')->comment('订单参数id');
            $table->string('union_order_code')->comment('订单总编号，由保险公司返回')->nullable();
            $table->integer('premium')->comment('订单价格')->nullable();
            $table->integer('ditch_id')->comment('渠道id')->nullable();
            $table->integer('warranty_id')->comment('保单id')->nullable();
            $table->integer('policy_id')->comment('投保人id,如果为0，则表示投保人和被保人是同一人')->nullable();
            $table->integer('agent_id')->comment('代理人')->nullable();
            $table->integer('beneficiary_id')->comment('受益人id')->nullable();
            $table->integer('ty_product_id')->comment('关联产品id')->nullable();
            $table->string('private_p_code')->comment('内部产品唯一码')->nullable();
            $table->integer('type')->comment('保单类型,0表示个人保单，1表示团险保单');
            $table->integer('status')->comment('状态')->default(0);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('warranty_relation', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('abbreviation')->comment('英文字母简称');
            $table->string('relation_name')->comment('投保人是被保人的');
            $table->integer('status')->comment('状态')->default(0);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });


        //订单投保人
        Schema::create('warranty_policy', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('name')->comment('投保人真实姓名');
            $table->string('card_type')->comment('证件类型');
            $table->string('occupation')->comment('职业类型没编号');
            $table->string('code')->comment('投保人身份标识');
            $table->string('phone')->comment('手机号');
            $table->string('email')->comment('电子邮箱');
            $table->string('area')->comment('住址');
            $table->integer('status')->comment('状态id')->default(0);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });


        //订单被保人
        Schema::create('warranty_recognizee', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('name')->comment('被保人真实姓名');
            $table->string('order_id')->comment('所属的订单');
            $table->string('relation')->comment('与创建者关系');
            $table->string('order_code')->comment('被保人的保单编号')->nullable();
            $table->string('occupation')->comment('职业类型编号');
            $table->string('card_type')->comment('证件类型');
            $table->string('code')->comment('被保人身份标识');
            $table->string('phone')->comment('被保人手机号');
            $table->string('email')->comment('被保人电子邮箱');
            $table->timestamp('start_time')->comment('开始时间')->nullable();
            $table->timestamp('end_time')->comment('结束时间')->nullable();
            $table->integer('status')->comment('状态id');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });






        //受益人关联
        Schema::create('beneficiary_rule', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->integer('order_id')->comment('保单id');
            $table->integer('beneficiary_rule')->comment('被保人id');
            $table->integer('level')->comment('受益人级别');
            $table->integer('status')->comment("状态");
            $table->timestamps();
            $table->engine = 'InnoDB';
        });




        //订单投保人
        Schema::create('image', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->integer('order_id')->comment('订单id')->nullable();
            $table->integer('warranty_id')->comment('保单id')->nullable();
            $table->string('image')->comment('照片');
            $table->integer('status')->comment('状态');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });




    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_parameter');
        Schema::dropIfExists('warranty_relation');
        Schema::dropIfExists('warranty_rule');
        Schema::dropIfExists('warranty_policy');
        Schema::dropIfExists('warranty_recognizee');
        Schema::dropIfExists('beneficiary_rule');
        Schema::dropIfExists('order_prepare_parameter');
        Schema::dropIfExists('image');
    }
}
