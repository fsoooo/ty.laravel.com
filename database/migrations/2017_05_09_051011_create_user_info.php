<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //普通用户真实信息
        Schema::create('true_user_info', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('user_id')->comment('用户表ID');
            $table->bigInteger('card_id')->comment('证件号')->nullable();
            $table->text('card_img_front')->comment('身份证正面');
            $table->text('card_img_backend')->comment('身份证反面');
            $table->text('card_img_person')->comment('身份证手持');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        //企业用户真实信息
        Schema::create('true_firm_info', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->integer('user_id')->comment('用户表ID');
            $table->string('person_name')->comment('法人姓名')->nullable();
            $table->bigInteger('person_card_id')->comment('法人证件号')->nullable();
            $table->text('card_img_front')->comment('身份证正面')->nullable();
            $table->text('card_img_backend')->comment('身份证反面')->nullable();
            $table->text('ins_principal')->comment('企业团险负责人姓名')->nullable();
            $table->bigInteger('ins_phone')->comment('企业团险负责人联系方式')->nullable();
            $table->bigInteger('ins_principal_code')->comment('企业团险负责人身份证号')->nullable();
            $table->string('ins_email')->comment('企业团险负责人邮箱')->nullable();
            $table->text('license_group_id')->comment('组织机构代码')->nullable();
            $table->text('license_img')->comment('营业执照')->nullable();
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
        Schema::dropIfExists('true_user_info');
        Schema::dropIfExists('true_firm_info');
    }
}
