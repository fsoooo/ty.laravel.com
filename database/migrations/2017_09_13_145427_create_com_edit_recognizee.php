<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComEditRecognizee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit_recognizee', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('user_id')->comment('当前登陆账户的id');
            $table->string('name')->comment('被保人姓名');
            $table->string('id_type')->comment('被保人证件类型');
            $table->string('date')->comment('被保人起保日期');
            $table->string('project')->comment('选择方案');
            $table->bigInteger('id_code')->comment('被保人证件号');
            $table->string('email')->comment('邮箱')->nullable();
            $table->integer('status')->comment('1为刚添加未审核，2为审核通过，3为审核未通过');
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
        Schema::dropIfExists('edit_recognizee');
    }
}
