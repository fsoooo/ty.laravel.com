<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComOrderBrokerage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_brokerage', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer("order_id")->comment('订单id');
            $table->string('order_pay')->comment('订单总金额');
            $table->integer('ty_product_id')->comment('ty产品ID');
            $table->integer('rate_relation_id')->comment('代理人佣金比例ID');
            $table->string('by_stages_way')->comment('分期方式');
            $table->integer('rate')->comment('订单佣金比率');
            $table->integer('user_earnings')->comment('代理人收入')->nullable();
            $table->integer('agent_id')->comment('代理人id');
            $table->integer('ditch_id')->comment('渠道id');
            $table->integer('is_settlement')->comment('是否已经结算，0表示未结算，1表示一结算')->default(1);
            $table->integer('status')->comment('佣金支付状态状态')->default(1);
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
        Schema::dropIfExists('order_brokerage');
    }
}
