<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComClaim extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //理赔表
        Schema::create('claim', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id,自增');
            $table->string('phone')->comment('发起理赔人员的手机号码');
            $table->string('account')->comment('理赔收款账号');
            $table->string('bank_name')->comment('收款账号的开户行')->nullable();
            $table->integer('account_type')->comment('用来判断收款账户的类型，1表示银行卡，2表示支付宝账号，3表示微信');
            $table->integer('status')->comment('理赔状态，此状态与理赔表中的状态相关联');
            $table->timestamps();
        });
//          理赔关联表
        Schema::create('claim_rule', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id,自增');
            $table->integer('from_id')->comment('所属中介公司id');
            $table->string('user_id')->comment('客户的id');
            $table->integer('order_id')->comment('订单id');
            $table->integer('claim_id')->comment('理赔记录的id');
            $table->integer('status')->comment('状态id');
            $table->timestamps();
        });

        //理赔记录表
        Schema::create('claim_record', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id,自增');
            $table->string('operation_name')->comment('处理人的姓名');
            $table->string('claim_remarks')->comment('理赔的备注信息')->nullable();
            $table->string('status_name')->comment('处理后的状态名称');
            $table->integer('claim_id')->comment('理赔的id，与claim表中 的id对应');
            $table->string('claim_suggest')->comment('理赔的建议')->nullable();
            $table->timestamps();
        });
        //理赔图片关联表
        Schema::create('claim_url', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('claim_id')->comment('理赔id');
            $table->string('claim_url')->comment('理赔对应的单据地址');
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
        Schema::dropIfExists('claim');
        Schema::dropIfExists('claim_rule');
        Schema::dropIfExists('claim_record');
        Schema::dropIfExists('claim_url');
    }
}
