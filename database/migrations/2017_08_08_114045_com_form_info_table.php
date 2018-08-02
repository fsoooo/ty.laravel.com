<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ComFormInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_info', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->longText('forminfo')->comment('投保信息');
            $table->string('identification')->comment('预订单号');
            $table->string('union_order_code')->default(null)->comment('联合订单号');
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
        Schema::dropIfExists('form_info');
    }
}
