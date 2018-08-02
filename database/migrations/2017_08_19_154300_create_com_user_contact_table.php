<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComUserContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_contact', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('user_id')->default(null)->comment('用户表关联ID');
            $table->string('name')->comment('姓名');
            $table->string('id_type')->comment('证件类型');
            $table->string('id_code')->comment('证件号码');
            $table->string('phone')->comment('用户电话');
            $table->string('email')->comment('用户邮箱');
            $table->string('occupation')->comment('用户职业');
            $table->string('address')->default(null)->comment('用户住址');
            $table->string('uuid')->comment('api_from_uuid');
            $table->string('relation')->comment('与投保人关系');
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
        //
        Schema::dropIfExists('user_contact');
    }
}
