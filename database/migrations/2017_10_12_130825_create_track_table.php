<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('referrer')->comment('获取上个页面跳转过来的url（推荐人）')->nullable()->default('直接输入网址或书签');
            $table->string('url')->comment('url');
            $table->string('ip')->comment('ip');
            $table->string('region')->comment('ip所属地');
            $table->timestamp('visit_time')->comment('访问时间')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('track');
    }
}
