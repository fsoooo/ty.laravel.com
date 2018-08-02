<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComGroupInsCust extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_ins_cust', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string('ty_beibaoren_name',255)->comment('被保人姓名');
            $table->string('ty_beibaoren_id_number',255)->comment('被保人身份证号');
            $table->string('ty_beibaoren_job',255)->comment('被保人职业');
            $table->bigInteger('ty_beibaoren_phone')->comment('主键');
            $table->string('union_order_code',255)->nullable()->comment('主键');
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
    }
}
