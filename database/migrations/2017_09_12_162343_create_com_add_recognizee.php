<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComAddRecognizee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_recognizee', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('user_id')->comment('当前登陆账户的id');
            $table->string('name')->comment('被保人姓名');
            $table->string('sex')->comment('被保人性别')->nullable();
            $table->string('id_type')->comment('被保人证件类型');
            $table->string('date')->comment('被保人起保日期');
            $table->string('project')->comment('选择方案');
            $table->bigInteger('id_code')->comment('被保人证件号');
            $table->string('birthday')->comment('被保人生日')->nullable();
            $table->string('occupation')->comment('被保人职业')->nullable();
            $table->bigInteger('phone')->comment('被保人电话');
            $table->string('healthy')->comment('是否健康')->nullable();
            $table->integer('status')->comment('添加状态');
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
        Schema::dropIfExists('add_recognizee');
    }
}
