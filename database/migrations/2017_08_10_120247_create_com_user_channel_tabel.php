<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComUserChannelTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_channel', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('user_id')->default(null)->comment('用户表关联ID');
            $table->string('channel_only_id')->comment('渠道唯一标识ID');
            $table->string('name')->comment('用户姓名');
            $table->string('person_code')->comment('用户身份标识');
            $table->string('phone')->comment('用户电话');
            $table->string('email')->comment('用户邮箱');
            $table->string('address')->default(null)->comment('用户住址');
            $table->integer('status')->comment('状态')->default(0);
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
        Schema::dropIfExists('user_channel');
    }
}
