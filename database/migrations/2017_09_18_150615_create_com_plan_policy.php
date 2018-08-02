<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComPlanPolicy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_policy', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('name')->comment('投保人姓名');
            $table->bigInteger('phone')->comment('投保人手机号');
            $table->string('email')->comment('投保人邮箱')->nullable();
            $table->integer('user_id')->comment('关联users表')->nullable();
            $table->string('other')->comment('其他补充信息')->nullable();
            $table->integer('status')->comment('备用状态,初期可能涉及是否已经投保');
            $table->integer('agent_id')->comment('代理人id');
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
        Schema::dropIfExists('plan_policy');
    }
}
