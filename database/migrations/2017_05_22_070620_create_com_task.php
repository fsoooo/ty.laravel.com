<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->enum('type', ['year', 'season', 'month'])->comment('任务类型 年类型 季类型 月类型');
            $table->integer('money', false, true)->comment('任务应完成的额度');
            $table->string('desc', 255)->comment('描述信息');
            $table->timestamp('created_at');
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
        Schema::dropIfExists('task');
    }
}
