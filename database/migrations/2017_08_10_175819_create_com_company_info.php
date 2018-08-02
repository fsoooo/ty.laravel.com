<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComCompanyInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('company_info',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->string('company')->comment('企业名称');
            $table->integer('industry')->comment('企业所属行业');
            $table->integer('nature')->comment('企业性质');
            $table->integer('type')->comment('证件类型');
            $table->integer('code')->comment('证件号码');
            $table->string('path')->comment('证件路径');
            $table->string('address')->comment('办公地址');
            $table->integer('tel')->comment('公司电话');
            $table->string('name')->comment('联系人姓名');
            $table->integer('phone')->comment('联系人电话');
            $table->integer('email')->comment('联系人邮箱');
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
        Schema::drop('company_info');
    }
}
