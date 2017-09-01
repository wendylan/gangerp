<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuoteList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_list', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('bid');
//        $table->integer('uid');
        //cname   品名
        $table->string('cname')->default('');
        $table->integer('cname_cid');
        //size  规格
        $table->string('size')->default('');
        $table->integer('size_cid');

        //material 材质
        $table->string('material')->default('');
        $table->integer('material_cid');

        //amount  重量
        $table->mediumInteger('amount')->default(0);

        //mark 备注
        $table->string('mark')->default('');

        //类型   1 批次   2 统一网价  3  分品牌
        $table->integer('type')->default(0);

        $table->integer('brand_id');
        $table->string('bname');
        //基础价  1，下单日我的钢铁网价格 2，到货日我的钢铁网价格 3，下单日广州刚才批发网价格 4，到货日广州批发网价格
        $table->integer('base_type');
       //上浮 1  下浮 2
        // $table->integer('up_down');
        // //网价
        // $table->float('net_price');
        //     //上下浮动
        // $table->float('up_price');

        $table->timestamps();
        $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quote_list');
    }
}
