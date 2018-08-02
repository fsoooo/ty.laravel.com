<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('name')->comment('姓名');
            $table->integer('id_type')->comment('证件类型');
            $table->string('birthday')->comment('生日');
            $table->bigInteger('id_code')->comment('身份证号');
            $table->bigInteger('phone')->comment('手机号');
            $table->bigInteger('email')->comment('邮箱');
            $table->string('address')->comment('居住地');
            $table->integer('user_id')->comment('用户id');
            $table->string('inAddress')->comment('详细地址');
            $table->integer('postCode')->comment('邮编');
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
        Schema::dropIfExists('contacts');
    }
}
