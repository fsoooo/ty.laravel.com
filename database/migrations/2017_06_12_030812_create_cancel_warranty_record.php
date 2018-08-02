<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCancelWarrantyRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancel_warranty_record', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->integer('order_id')->comment('退保对应的订单id');
            $table->integer('user_id')->comment('申请人id');
            $table->timestamp('hesitation')->comment('犹豫期结束时间');
            $table->timestamp('apply_time')->comment('退保申请时间');
            $table->integer('type')->comment('判断是否在犹豫期内');
            $table->string('result')->comment('退保理由');
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
        Schema::dropIfExists('cancel_warranty_record');
    }
}
