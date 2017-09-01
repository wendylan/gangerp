<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('province');
            $table->bigInteger('city');
            $table->bigInteger('area');
            $table->string('add');
            $table->string('brands');
            $table->integer('mtype');//计量方式
            $table->text('settlement');//结算条件
            $table->integer('paytype');
            $table->string('quote_request');
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
        Schema::drop('project');
    }
}
