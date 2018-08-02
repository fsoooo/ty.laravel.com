<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->integer('send_id')->comment('发送者id,0代表业管');
            $table->integer('accept_type')->comment('接收者类型，0代表客户,1代表普通用户，2代表企业客户，3代表代理人');
            $table->integer('accept_id')->comment('接受者id，全部使用user表中的主键');
            $table->string('content')->comment('通知内容')->nullable();
            $table->string('timing')->comment('定时发送时间')->nullable();
            $table->integer('status')->comment('消息状态,1刚添加，2已发送，3已读');
            $table->string('send_time')->comment('实际发送时间')->nullable();
            $table->string('look_time')->comment('阅读时间')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
