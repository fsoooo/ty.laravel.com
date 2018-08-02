<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComEvolveRule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('evolve_rule', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('主键id,自增');
            $table->integer('evolve_id')->comment('联系记录的id');
            $table->integer('agent_id')->comment('代理人的id');
            $table->integer('from_id')->comment('所属中介的id');
            $table->integer('cust_id')->comment('客户的id');
            $table->string('code')->comment('客户的身份标识');
            $table->integer('status')->comment('状态');
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
        Schema::dropIfExists('evolve_rule');
    }
}
