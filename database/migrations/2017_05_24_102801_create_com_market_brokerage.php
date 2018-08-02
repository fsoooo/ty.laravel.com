<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComMarketBrokerage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_ditch_relation', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('ty_product_id')->comment('ty产品id');
            $table->integer('ditch_id')->comment('渠道id');
            $table->integer('agent_id')->comment('代理人id')->default(0);
            $table->string('by_stages_way')->comment('分期方式');
            $table->integer('rate')->comment('佣金比')->default(0);
            $table->string('status')->default('on')->comment("状态 on激活 off关闭");
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
//        Schema::create('scaling', function (Blueprint $table) {
//            $table->increments('id')->comment('主键');
//            $table->integer('product_id')->comment('产品id');
//            $table->integer('ditch_id')->comment('渠道id');
//            $table->integer('agent_id')->comment('代理人id')->default(0);
//            $table->string('type')->comment('折标系数类型');
//            $table->integer('rate')->comment('折标系数')->default(0);
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
        Schema::dropIfExists('market_ditch_relation');
//        Schema::dropIfExists('scaling');
    }
}
