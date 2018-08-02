<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComCust extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cust', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id,自增');
            $table->string('name')->comment('客户的姓名');
            $table->string('code')->comment('客户的身份标识');
            $table->string('email')->default('')->nullable()->comment('客户的联系邮箱');
            $table->string('occupation')->nullable()->comment('客户职业');
            $table->integer('type')->nullable()->comment('客户类型');
            $table->integer('id_type')->nullable()->comment('客户身份证件类型');
            $table->string('phone')->default('')->nullable()->comment('客户的电话');
            $table->text('other')->nullable()->comment('其他内容');
            $table->integer('status')->default(0)->comment('判断当前信息的状态');
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
        Schema::dropIfExists('cust');
    }
}
