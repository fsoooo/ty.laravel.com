<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComMaintenanceRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
//    保全记录表
    public function up()
    {
        Schema::create('maintenance_record', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
//            $table->integer('warranty_id')->comment('保单id');
//            $table->integer('warranty_type')->comment('保单类型');
//            $table->integer('examine')->comment('用来判断是否需要审核');
            $table->integer('order_id')->comment('订单id');
            $table->integer('user_id')->comment('操作者id，用户id');
            $table->integer('order_type')->comment('订单类型，0表示是个险订单，1表示是团险订单');
            $table->string('change_content')->comment('修改内容');
            $table->string('change_type')->comment('修改类型');
            $table->integer('settlement')->comment('处理,0表示未处理,1表示已同意，2表示已拒绝')->default(0);
            $table->integer('status')->comment('状态')->default(0);
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
        Schema::dropIfExists('maintenance_record');
    }
}
