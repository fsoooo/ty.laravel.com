<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComApplyRule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('apply_rule', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id,自增');
            $table->integer('cust_id')->index()->comment('cust表中的客户信息');
            $table->integer('type')->index()->comment('用来判断所申请的客户类型，0表示个人客户，1表示企业客户');
            $table->integer('record_id')->index()->comment('所关联的记录的id，与apply_record中的id相关联');
            $table->integer('from_id')->default(0)->comment('所属中介id');
            $table->integer('agent_id')->index()->comment('代理人的id，此id为代理人表中的id');
            $table->string('code')->index()->comment('客户的身份标识');
            $table->integer('status')->index()->comment('申请的状态,0表示未处理，1表示已同意，2表示已拒绝');
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
        Schema::dropIfExists('apply_rule');
    }
}
