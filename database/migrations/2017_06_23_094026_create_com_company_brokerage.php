<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComCompanyBrokerage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //公司佣金统计
        Schema::create('company_brokerage', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->integer('order_id')->comment('订单id');
            $table->integer('warranty_id')->comment('保单id')->nullable();
            $table->integer('ty_product_id')->comment('ty产品id')->nullable();
            $table->string('brokerage')->comment('所获佣金');
            $table->integer('status')->comment('状态');
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
        //
        Schema::dropIfExists('company_brokerage');
    }
}
