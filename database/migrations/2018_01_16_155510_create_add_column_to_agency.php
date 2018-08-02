<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddColumnToAgency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channel_operate', function ($table) {
            $table->integer('is_work')->comment('是否上工');
            $table->string('work_start')->comment('上工时间');
        });
        Schema::table('channel_contract_info', function ($table) {
            $table->integer('is_valid')->default(0)->comment('签约是否有效');
            $table->integer('is_auto_pay')->default(0)->comment('是否自动投保');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
