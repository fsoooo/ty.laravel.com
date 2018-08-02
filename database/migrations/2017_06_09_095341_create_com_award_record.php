<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComAwardRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award_record', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->integer('competition_id')->comment('竞赛方案id');
            $table->integer('sum')->comment('已售价格')->nullable();
            $table->integer('count')->comment('已售数量')->nullable();
            $table->integer('award_rate')->comment('奖励比率')->nullable();
            $table->integer('award_money')->comment('固定奖励金额')->nullable();
            $table->integer('agent_id')->comment('用户id');
            $table->integer('status')->comment('状态');
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
        Schema::dropIfExists('award_record');
    }
}
