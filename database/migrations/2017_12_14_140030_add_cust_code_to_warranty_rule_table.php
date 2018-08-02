<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustCodeToWarrantyRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warranty_rule', function (Blueprint $table) {
            $table->integer('policy_cust_id')->nullable()->comment('投保人的客户id')->after('type');
            $table->string('recognize_cust_id',100)->nullable()->comment('被保人的客户id组')->after('policy_cust_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warranty_rule', function (Blueprint $table) {
            //
        });
    }
}
