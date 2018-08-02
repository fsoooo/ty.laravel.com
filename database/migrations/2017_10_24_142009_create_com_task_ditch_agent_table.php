<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComTaskDitchAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_ditch_agent', function (Blueprint $table) {
            $table->integer('task_id', false, true)->comment('任务ID');
            $table->integer('ditch_id', false, true)->comment('渠道ID');
            $table->integer('agent_id', false, true)->comment('代理人ID');
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
        Schema::dropIfExists('task_ditch_agent');
    }
}
