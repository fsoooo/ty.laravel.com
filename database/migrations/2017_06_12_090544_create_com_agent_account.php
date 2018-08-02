<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComAgentAccount extends Migration
{
    /**
     * Run the migrations.
     *代理人账户
     * @return void
     */
    public function up()
    {
        //代理人账户
        Schema::create('agent_account', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('sum')->comment('代理人当前账户余额,单位分');
            $table->date('settlement_date')->comment('结算时间，如果当天结算过，则不再重复结算');$table->integer('agent_id')->comment('代理人id');
            $table->integer('status')->comment('状态');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        //代理人佣金记录
        Schema::create('agent_account_record', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('money')->comment('变化的价格，单位分');
            $table->integer('agent_id')->comment('代理人的id');
            $table->string('operate')->comment('操作类型');
            $table->integer('competition_id')->comment('活动id')->nullable();
            $table->string('balance')->comment('变化后的账户余额');
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
        Schema::dropIfExists('agent_account');
        Schema::dropIfExists('agent_account_record');
    }
}
