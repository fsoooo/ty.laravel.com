<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCustTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cust', function (Blueprint $table) {
            $table->string('company_name',100)->nullable()->comment('企业名称')->after('other');
            $table->tinyInteger('is_three_company')->nullable()->comment('是否是三证合一企业')->after('company_name');
            $table->string('organization_code',50)->nullable()->comment('组织机构代码')->after('is_three_company');
            $table->string('license_code',50)->nullable()->comment('营业执照编码')->after('organization_code');
            $table->string('tax_code',50)->nullable()->comment('纳税人识别号')->after('license_code');
            $table->string('province',20)->nullable()->comment('省')->after('tax_code');
            $table->string('city',20)->nullable()->comment('城市')->after('province');
            $table->string('county',20)->nullable()->comment('区／县')->after('city');
            $table->string('street_address',200)->nullable()->comment('详细地址')->after('county');
            $table->string('license_image',200)->nullable()->comment('营业执照图片')->after('street_address');
            $table->string('cust_from',50)->nullable()->comment('客户来源(个人，企业，代理人，业管)')->after('license_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cust', function (Blueprint $table) {
            //
        });
    }
}
