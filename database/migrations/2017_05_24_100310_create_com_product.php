<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //产品表
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('product_number')->comment('产品的唯一标识');
            $table->string('private_p_code')->comment('产品的内部唯一标识');
            $table->integer('ty_product_id')->comment('产品ID');
            $table->string('api_from_uuid')->comment('产品接口代码');
            $table->string('product_name')->comment('产品名称');
            $table->integer('insure_type')->comment('产品类型，1代表个险，2代表团险');
            $table->integer('base_price')->comment('基础价格')->default(0);
            $table->string('base_stages_way')->comment('默认缴别')->nulable();
            $table->integer('base_ratio')->comment('默认缴费对应佣金比')->default(0);
            $table->string('company_name')->comment('公司名称');
            $table->string('company_email')->comment('公司邮箱');
            $table->string('product_category')->comment('产品分类');
            $table->string('cover')->comment('封面图片')->default('/r_backend/v2/img/396658748210103920.jpg');
            $table->longText('json')->comment('产品信息');
            $table->longText('clauses')->comment('产品相关条款');
            $table->longText('personal')->default(null)->comment('个性化');
            $table->integer('status')->default('0')->comment('状态，上架，下架');
            $table->integer('sale_status')->default('0')->comment('状态，在售，停售');
            $table->integer('delete_id')->default('0')->comment('产品删除');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        //产品下架原因
        Schema::create('product_down_reason', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('ty_product_id')->comment('产品ID，和产品关联');
            $table->string('product_down_labels')->comment('产品选择下架标签');
            $table->string('product_down_content')->comment('产品下架原因说明');
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
        //产品表
        Schema::dropIfExists('product');
        //产品下架原因
        Schema::dropIfExists('product_down_reason');
    }
}
