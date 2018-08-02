<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComCommunication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communication',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->integer('user_id')->comment('关联users表');
            $table->integer('ty_product_id')->comment('关联产品表');
            $table->integer('agent_id')->comment('当前代理人id');
            $table->integer('grade')->comment('对当前用户沟通的购买意向评分');
            $table->text('content')->comment('沟通内容')->nullable();
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
        Schema::dropIfExists('communication');
    }
}
