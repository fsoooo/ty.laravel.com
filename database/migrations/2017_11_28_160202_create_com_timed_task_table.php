<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComTimedTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timed_task',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->string('task_name')->comment('任务名称');
            $table->string('task_type')->comment('任务类型')->nullable();
            $table->string('service_ip')->comment('服务器IP')->nullable();
            $table->string('start_time')->comment('任务开始时间')->nullable();
            $table->string('task_time')->comment('任务执行时间')->nullable();
            $table->string('end_time')->comment('任务结束时间')->nullable();
            $table->string('timestamp')->comment('执行时间')->nullable();
            $table->string('status')->comment('状态');
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
        Schema::dropIfExists('timed_task');
    }
}
