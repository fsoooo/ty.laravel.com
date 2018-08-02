<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComEvaluate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluate',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->integer('relation_id')->comment('被评价的id');
            $table->string('relation_type')->comment('被评价的类型（product,cust,agent）');
            $table->string('relation_type_from')->comment('给的评价的人的类型');
            $table->integer('relation_type_from_id')->comment('给评论的人的类型');
            $table->integer('grade')->comment('评分');
            $table->integer('lable_id')->comment('评价的标签')->nullable();
            $table->text('content')->comment('评论的内容')->nullable();
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
        Schema::dropIfExists('evaluate');
    }
}
