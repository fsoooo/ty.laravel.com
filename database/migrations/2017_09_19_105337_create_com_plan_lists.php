<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComPlanLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_lists', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('name')->nullable()->comment('计划书名称');
            $table->integer('plan_recognizee_id')->comment('关联计划书被保人表id');
            $table->integer('ty_product_id')->comment('产品id');
            $table->integer('agent_id')->comment('制作计划书代理人id');
            $table->string('url')->comment('生成的计划书url')->nullable();
            $table->text('selling')->comment('卖点')->nullable();
            $table->integer('status')->comment('是否已经发送给客户的状态 0未发送 1已发送 2已读 3完成支付');
            $table->timestamp('read_time')->comment('阅读时间')->nullable();
            $table->string('send_time')->comment('发送时间')->nullable();
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
        Schema::dropIfExists('plan_lists');
    }
}
