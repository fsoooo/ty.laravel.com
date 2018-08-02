<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('invoice',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->string('name')->comment('收件人姓名');
            $table->integer('phone')->comment('收件人电话');
            $table->integer('status')->comment('发票状态');
            $table->string('address')->comment('发票收件地址');
            $table->integer('user_id')->comment('与users表关联的用户id');
            $table->integer('type')->comment('发票类型，1是增值税普通发票，2是增值税专用发票');
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
        Schema::drop('invoice');
    }
}
