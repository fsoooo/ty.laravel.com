<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComCompanySlip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_slip',function(Blueprint $table){
            $table->increments('id')->comment('主键');
            $table->string('code')->comment('保单号');
            $table->integer('name')->comment('保险名称');
            $table->integer('math')->comment('被保人数');
            $table->string('status')->comment('状态');
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
        Schema::drop('company_slip');
    }
}
