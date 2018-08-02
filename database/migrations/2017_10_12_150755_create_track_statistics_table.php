<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_Statistics', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->integer('uv')->comment('访问次数');
            $table->integer('only_uv')->comment('独立访客');
            $table->integer('new_uv')->comment('新独立访客');
            $table->integer('pv')->comment('网址浏览量');
            $table->integer('ip')->comment('独立ip');
            $table->integer('sum_browse')->comment('站内总浏览量');
            $table->timestamp('time')->comment('时间')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('track_Statistics');
    }
}
