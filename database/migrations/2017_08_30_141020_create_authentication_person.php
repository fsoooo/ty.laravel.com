<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthenticationPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authentication_person', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('user_id')->comment('用户表主键');
            $table->string('name')->comment('用户真是姓名');
            $table->bigInteger('code')->comment('用户身份证号')->nullable();
            $table->integer('status')->comment('认证状态,0代表上传文件未进行处理，1代表认证失败，2代表成功');
            $table->integer('id_type')->comment('证件类型,1代表身份证');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('authentication_person');
    }
}
