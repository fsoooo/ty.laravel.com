<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComPlanRecognizee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_recognizee', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('user_id')->comment('关联users表');
            $table->integer('relation')->comment('与投保人的关系');
            $table->string('name')->comment('被保人姓名');
            $table->integer('sex')->nullable()->comment('被保人性别,1代表男，0代表女');
            $table->integer('agent_id')->comment('代理人id');
            $table->integer('plan_policy_id')->comment('计划书投保人表id')->nullable();
            $table->string('birthday')->comment('被保人生日');
            $table->string('occupation')->comment('被保人职业');
            $table->bigInteger('id_code')->comment('被保人身份证号');
            $table->bigInteger('phone')->comment('被保人手机号')->nullable();
            $table->string('email')->comment('被保人邮箱')->nullable();
            $table->string('other')->comment('其他补充信息')->nullable();
            $table->integer('status')->comment('备用状态,初期可能涉及是否已经投保');
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
        Schema::dropIfExists('plan_recognizee');
    }
}
