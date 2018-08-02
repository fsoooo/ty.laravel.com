<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComCustRule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cust_rule', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id,自增');
            $table->string('code')->comment('客户的身份标识');
            $table->integer('user_id')->index()->comment('关联user表的id');
            $table->integer('from_id')->index()->comment('所属来源的id');
            $table->integer('agent_id')->index()->comment('添加人员的id，如果为0，则表示是管理人员添加')->nullable();
            $table->integer('type')->index()->comment('判断当前客户类型，0是个人客户，1是企业客户');
            $table->integer('from_type')->index()->comment('判断当前客户来源，0表示是代理人添加，1表示是中介公司添加');
            $table->integer('status')->comment('判断当前信息的状态');
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
        Schema::dropIfExists('cust_rule');
    }
}
