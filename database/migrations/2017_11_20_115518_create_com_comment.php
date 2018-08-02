<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->string('commentable_type')->comment('关系模块的模型层类名')->nullable();
            $table->integer('commentable_id')->comment('对应表的主键');
            $table->integer('send_id')->comment('发送者id,0代表业管');
            $table->integer('recipient_id')->comment('接收者id,0代表业管，-1代表天眼后台,-2代理人，-3客户');
            $table->string('content')->comment('评论内容');
            $table->integer('status')->comment('状态,1刚添加，2已发送，3已读');
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
        Schema::dropIfExists('comment');
    }
}
