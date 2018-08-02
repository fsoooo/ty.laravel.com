<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComTaskCondition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_condition', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('task_id')->comment('任务id');
            $table->string('sum')->comment('应完成的金额条件,单位分');
            $table->integer('task_condition_type')->comment('任务类型，1表示不计算折标率，2表示计算折标率');
            $table->integer('product_id')->comment('特定产品的完成条件，如果值为0，则说明没有特殊的要求');
            $table->integer('area_id')->comment('特定地域的id，如果值为0，则说明没有特殊要求');
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
        Schema::dropIfExists('task_condition');
    }
}
