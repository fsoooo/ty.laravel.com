<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComUserThirdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_third', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('user_id')->comment('用户表关联ID');
            $table->string('api_type')->comment('接口类型，1:QQ,2:WeChat,3:Webo');
            $table->string('app_id','100')->unique()->comment('app_ID');
            $table->string('name')->comment('用户昵称');
            $table->string('img')->comment('用户头像');
            $table->string('sex')->comment('用户性别');
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
        Schema::dropIfExists('user_third');
    }
}
