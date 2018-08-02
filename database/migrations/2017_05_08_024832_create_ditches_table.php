<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDitchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //渠道
        Schema::create('ditches', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('name')->comment('全称');
            $table->string('display_name')->comment('简称');
            $table->string('address')->comment('地址')->nullable();
            $table->string('phone')->comment('联系电话')->nullable();
            $table->string('group_code')->comment('组织结构代码')->nullable();
            $table->string('credit_code')->comment('信用码')->nullable();
            $table->enum('type', ['external_group', 'son_group', 'internal_group'])->comment('渠道分类 分别对应 外部合作 分公司 内部分组');
            $table->enum('status', ['on', 'off'])->default('on')->comment('启用 禁用');
            $table->integer('pid')->default(0)->comment('父类ID');
            $table->integer('sort')->default(0)->comment('权重');
            $table->string('path')->default(',0,')->comment('父类路径');
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //代理人
        Schema::create('agents', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('job_number')->comment('代理人工号');
            $table->string('area')->comment('代理人地区')->nullable();
            $table->string('position')->comment('代理人职位')->nullable();
            $table->integer('user_id')->comment('用户表ID');
            $table->string('email', 100)->comment('邮箱')->nullable();
            $table->string('phone', 11)->unique()->comment('手机号');
            $table->string('address')->comment('地址')->nullable();
            $table->tinyInteger('pending_status')->default(0)->comment('审核状态 0待审核 1通过');
            $table->tinyInteger('certification_status')->default(0)->comment('实名状态 0未实名 1已实名');
            $table->tinyInteger('work_status')->default(0)->comment('是否在职 0离职 1在职');
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //关系
        Schema::create('ditch_agent', function (Blueprint $table) {
            $table->integer('ditch_id')->unsigned();
            $table->integer('agent_id')->unsigned();
//            $table->foreign('ditch_id')->references('id')->on('ditches');
//            $table->foreign('agent_id')->references('id')->on('agents');
            $table->string('status')->default('on')->comment('状态 on 激活 off 关闭');
            $table->primary(['ditch_id', 'agent_id']);
            $table->engine = 'InnoDB';
        });

        //佣金
//        Schema::create('brokerages', function (Blueprint $table) {
//            $table->increments('id')->comment('主键');
//            $table->integer('ditch_id')->unsigned()->nullable();
//            $table->integer('agent_id')->unsigned()->nullable();
//            $table->integer('ty_product_id')->comment('产品ID');
//            $table->integer('order_id')->comment('订单id');
//            $table->integer('warranty_id')->comment('保单id')->nullable();
//            $table->integer('relation_id')->comment('佣金比例ID');
//            $table->string('by_stages_way')->comment('分期方式');
//            $table->string('brokerage')->comment('所获佣金');
//            $table->string('status')->default('wait_clear')->comment('结算状态 wait_clear 待结算 clear_ing 结算中 clear_end 完成结算');
////            $table->integer('pay_step_id')->comment('支付步骤ID');
////            $table->string('private_p_code')->comment('唯一码');
//            $table->softDeletes();
//            $table->timestamps();
//            $table->engine = 'InnoDB';
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('ditches');
        Schema::dropIfExists('agents');
        Schema::dropIfExists('ditch_agent');
//        Schema::dropIfExists('brokerages');
    }
}
