<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComMessageStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_statistics',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->integer('rec_id')->comment('接受者id');
            $table->integer('mes_id')->comment('消息id');
            $table->integer('status')->comment('消息状态');
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
        Schema::dropIfExists('messages_statistics');
    }
}
