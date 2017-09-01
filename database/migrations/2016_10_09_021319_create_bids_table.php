<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->integer('pid');
            $table->integer('bid');
            $table->integer('type');//招标类型（项目，批次）
            $table->integer('mtype');//计量方式
            $table->bigInteger('amount');//材料总量
            $table->text('settlement');//结算条件
            $table->integer('paytype');
            $table->string('quote_request');
            $table->string('deposit');//保证金
            $table->integer('deposit_type');
            $table->string('deposit_account');
            $table->string('deposit_bank_name');
            $table->dateTime('tender_deadline');
            $table->string('deposit_return');
            $table->string('tender_price');
            $table->string('tender_add');
            $table->dateTime('tender_open_sale');
            $table->dateTime('bid_deadline');
            $table->dateTime('bod');
            $table->bigInteger('delivery_day');
            //$table->text('quote_list');
            $table->bigInteger('quote_list_id');
            //项目招标，报价清单   1 统一价   2 分品牌
            $table->Integer('quote_list_type');
            $table->text('remark');
            $table->string('bid_to');//定向招标
            $table->integer('stage');//阶段
            $table->string('status');//状态
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
        Schema::dropIfExists('bids');
    }
}
