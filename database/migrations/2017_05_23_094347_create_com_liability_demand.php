<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComLiabilityDemand extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //需求表单
        Schema::create('liability_demand', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('module')->comment('需求所属模块：1客户 2产品 3计划书 4销售业绩 5销售任务 6活动 7消息 8评价 9账户设置');
            $table->integer('recipient_id')->comment('接收者id：0业管 -1天眼后台');
            $table->integer('agent_id')->comment('创建者代理人id 0 代表业管发送');
            $table->string('title')->comment('工单标题');
            $table->integer('content')->comment('工单内容');
            $table->string('time')->comment('暂定用于插入业管阅读时间')->nullable();
            $table->integer('status')->comment('工单状态:1已发送 2交流中 3已结束');
            $table->integer('close_status')->comment('关闭状态:1已解决 2无需解决 3其他原因')->nullable();
            $table->string('reason')->comment('关闭原因');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        //需求报价及产品组合表单
        Schema::create('demand_offer', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('demand_id')->comment('需求id');
            $table->longText('product_list')->comment('产品列表');
            $table->string('demand_name')->comment('方案名称');
            $table->longText('parameter')->comment('参数');
            $table->integer('offer')->comment('报价');
            $table->integer('status')->default(0)->comment('状态');
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
        Schema::dropIfExists('liability_demand');
        Schema::dropIfExists('demand_offer');
    }
}
