<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('create_id')->comment('创建者-用户表中ID');
            $table->enum('relation', ['f', 'm', 's', 'd', 'w', 'h', 'self','staff'])->comment('与创建者关系');
            $table->string('name')->comment('姓名');
            $table->enum('card_type', ['sfz', 'hz', 'jgz', 'qt'])->comment('证件类型');
            $table->string('card_id')->comment('证件号');
            $table->string('phone')->comment('手机号');
            $table->string('email')->comment('邮件地址');
            $table->enum('sex', ['m', 'w'])->comment('性别');
            $table->string('work')->comment('职业');
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
        Schema::dropIfExists('user_contacts');
    }
}
