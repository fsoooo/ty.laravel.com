<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_detail', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('ditch_id', false, true)->comment('渠道ID');
            $table->integer('agent_id', false, true)->comment('代理人ID');
            $table->string('year', 4)->comment('年份');
            $table->string('month', 2)->comment('月份');
            $table->integer('money')->comment('额度 乘以100入库');
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
        Schema::dropIfExists('task_detail');
    }
}
