<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComBehaviour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('behaviour', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id,自增');
            $table->integer('node_id')->comment('对应的节点id');
            $table->integer('status_id')->comment('对应的状态id');
            $table->integer('is_possible')->comment('是否可执行');
            $table->string('describe')->comment('对行为状态的描述')->nullable();
            $table->string('return_message')->comment('如果错误返回的信息')->nullable();
            $table->integer('status')->comment('行为规范的状态');
            $table->timestamps();
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
        Schema::dropIfExists('behaviour');
    }
}
