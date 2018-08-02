<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComIntersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('inters', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('token')->comment('接口token');
            $table->string('company_id',100)->comment('公司ID');
            $table->integer('price')->default('5')->comment('接口计价方式');
            $table->integer('money')->default('10')->comment('余额');
            $table->integer('status')->default(1)->comment('状态0未开启，1开启，2，欠费 ');
            $table->integer('is_pay')->default(0)->comment('是否支付');
            $table->integer('inter_nums')->default(0)->comment('计数');

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
        //
        Schema::dropIfExists('inters');
    }
}
