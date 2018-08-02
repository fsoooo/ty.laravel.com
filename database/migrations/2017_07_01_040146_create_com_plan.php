<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('plan', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('plan_name')->comment('计划书名称');
            $table->integer('product_id')->comment('产品id');
            $table->longText('parameter')->comment('参数');
            $table->string('url')->comment('网址');
            $table->integer('type')->comment('用来分辨主险还是附加险，主险0，附加险1');
            $table->integer('parent_id')->comment('附加险关联的主险计划，若为主险，则为0');
            $table->longText('main_clause')->comment('主险条款');
            $table->longText('attach_clause')->comment('附加险条款')->nullable();
            $table->integer('ditch_id')->comment('渠道id');
            $table->integer('agent_id')->comment('代理人id');
            $table->string('sole_code')->comment('唯一标识')->nullable;
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
        //
        Schema::dropIfExists('plan');
    }
}
