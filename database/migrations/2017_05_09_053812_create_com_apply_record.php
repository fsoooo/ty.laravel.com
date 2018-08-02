<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComApplyRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('apply_record', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id,自增');
            $table->string('apply_remarks')->comment('申请的备注信息')->nullable();
            $table->string('code')->index()->comment('客户的身份标识');
            $table->string('name')->comment('客户的名称');
            $table->string('phone')->comment('客户的联系电话')->nullable();
            $table->string('email')->comment('客户的邮箱')->nullable();
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
        Schema::dropIfExists('apply_record');
    }
}
