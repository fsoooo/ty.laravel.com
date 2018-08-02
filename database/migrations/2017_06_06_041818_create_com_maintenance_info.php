<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComMaintenanceInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
//    保全记录表
    public function up()
    {
        Schema::create('maintenance_info', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('union_order_id')->comment('联合订单号');
            $table->longText('save_input')->comment('保存输入内容');
            $table->longText('input')->comment('第一次输入内容');
            $table->longText('change_input')->comment('修改内容');
            $table->integer('status')->comment('状态');
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
        Schema::dropIfExists('maintenance_info');
    }
}
