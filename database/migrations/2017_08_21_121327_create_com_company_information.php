<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComCompanyInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_information',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->string('company_name')->comment('企业名称');
            $table->string('legal_person')->comment('法人姓名');
            $table->integer('personal_type')->comment('法人证件类型');
            $table->bigInteger('personal_code')->comment('法人证件号');
            $table->bigInteger('company_code')->comment('组织机构代码证号');
            $table->bigInteger('tel')->comment('公司办公电话');
            $table->string('address')->comment('公司办公地址');
            $table->string('email')->comment('公司投保负责人邮箱');
            $table->string('path')->comment('证件上传地址');
            $table->integer('status')->comment('审核状态');
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
        Schema::dropIfExists('company_information');
    }
}
