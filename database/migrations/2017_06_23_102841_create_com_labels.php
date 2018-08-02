<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComLabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //标签表
        Schema::create('labels', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('name')->comment('标签名称');
            $table->string('cover')->comment('标签封面图片（old）可空')->nullable();
            $table->string('description')->comment('标签内容（old）可空')->nullable();
            $table->string('parent_id')->default('0')->comment('分类的父级id,如果为0则表示是标签组');
            $table->string('label_type')->comment('标签类型：全局标签global，特有标签special，个人标签user,公司标签comppany');
            $table->string('label_belong')->comment('标签归属：产品product,代理人agent，用户user');
            $table->string('order_by')->default(0)->comment('排序');
            $table->string('status')->default(0)->comment('状态');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        //标签关联表
        Schema::create('label_relevance', function (Blueprint $table) {
            $table->increments('id')->comment('主键id,自增');
            $table->string('label_relevance')->comment('标签关联ID,产品ty_product_id,用户user_id,代理人agent_id');
            $table->string('label_belong')->comment('关联类型：用户user，代理人agent，产品product');
            $table->string('label_type')->comment('标签类型：全局标签，特有标签，个人标签，公司标签')->nullable();
            $table->string('label_id')->comment('标签ID');
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
        Schema::dropIfExists('labels');
        Schema::dropIfExists('label_relevance');
    }
}
