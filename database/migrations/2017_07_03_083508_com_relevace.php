<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComRelevace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('occupation', function (Blueprint $table) {//职业关系
            $table->increments('id')->comment('主键id,自增');
            $table->string('api_from_uuid')->comment('api来源的唯一标识');
            $table->string('name')->comment('姓名');
            $table->string('number')->comment('编码');
            $table->integer('status')->comment('状态')->default(0);
            $table->engine = 'InnoDB';
        });
        Schema::create('relation', function (Blueprint $table) {//人际关系
            $table->increments('id')->comment('主键id,自增');
            $table->string('api_from_uuid')->comment('api来源的唯一标识');
            $table->string('name')->comment('姓名');
            $table->string('number')->comment('编码');
            $table->integer('status')->comment('状态')->default(0);
            $table->engine = 'InnoDB';
        });
        Schema::create('card_type', function (Blueprint $table) {//职业关系
            $table->increments('id')->comment('主键id,自增');
            $table->string('api_from_uuid')->comment('api来源的唯一标识');
            $table->string('name')->comment('姓名');
            $table->string('number')->comment('编码');
            $table->integer('status')->comment('状态')->default(0);
            $table->engine = 'InnoDB';
        });
        Schema::create('bank', function (Blueprint $table) {//职业关系
            $table->increments('id')->comment('主键id,自增');
            $table->string('api_from_uuid')->comment('api来源的唯一标识');
            $table->string('name')->comment('姓名');
            $table->string('number')->comment('编码');
            $table->string('code')->comment('代号');
            $table->integer('status')->comment('状态')->default(0);
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
        Schema::dropIfExists('occupation');
        Schema::dropIfExists('relation');
        Schema::dropIfExists('card_type');
        Schema::dropIfExists('bank');
    }
}
