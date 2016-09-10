<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('iid');//主键ID
            $table->integer('oid');//订单ID
            $table->integer('gid');//商品ID
            $table->string('goods_name');//商品名
            $table->float('price',7,2);//商品单价
            $table->smallinteger('amount');//购买数量
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
