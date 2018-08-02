<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComInsApiInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ins_api_info', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer("bind_id")->comment('产品来源关联表ID');
            $table->integer('ty_product_id')->comment('ty产品ID');
            $table->string('private_p_code')->comment('接口对应产品码');
            $table->longText('json')->comment('试算因子，投保属性');
            $table->string('sign')->comment('是否更新标识');
            $table->integer('status')->default(1)->comment('状态');
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
        Schema::dropIfExists('ins_api_info');
    }
}
