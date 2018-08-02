<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComWarranty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('warranty', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id,自增');
            $table->string('warranty_code')->comment('保单的编号');
            $table->integer('deal_type')->comment('成交类型，0表示线上成交，1表示线下成交');
            $table->integer('premium')->comment('保单价格');
            $table->string('warranty_url')->comment('电子保单下载地址')->nullable();
            $table->timestamp('start_time')->comment('开始时间')->nullable();
            $table->timestamp('end_time')->comment('结束时间')->nullable();
            $table->integer('status')->comment('保单的状态');
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
        Schema::dropIfExists('warranty');
    }
}
