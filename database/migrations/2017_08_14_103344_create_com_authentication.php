<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComAuthentication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authentication',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->string('name')->comment('公司名称');
            $table->bigInteger('code')->comment('组织结构代码')->nullable();
            $table->bigInteger('license_code')->comment('营业执照码')->nullable();
            $table->bigInteger('tax_code')->comment('纳税人识别码')->nullable();
            $table->bigInteger('credit_code')->comment('统一信用码')->nullable();
            $table->string('boss')->comment('法人姓名')->nullable();
            $table->string('status')->comment('认证状态');
            $table->integer('user_id')->comment('用户id');
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
        Schema::drop('authentication');
    }
}
