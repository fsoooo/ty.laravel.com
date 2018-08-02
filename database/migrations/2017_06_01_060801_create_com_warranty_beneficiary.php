<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComWarrantyBeneficiary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warranty_beneficiary', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('name')->comment('受益人真实姓名');
            $table->string('code_type')->comment('受益人身份证件类型');
            $table->string('code')->comment('受益人身份标识');
            $table->integer('phone')->comment('受益人手机号');
            $table->string('email')->comment('受益人电子邮箱');
            $table->integer('status')->comment('状态id');
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
        Schema::dropIfExists('warranty_beneficiary');
    }
}
