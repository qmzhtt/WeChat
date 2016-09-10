<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('oid');//主键ID
            $table->string("ordsn");//订单号
            $table->integer("uid");//消费者uid
            $table->string("openid");//消费者openid
            $table->string("address");//送货地址
            $table->string("name");//收货姓名
            $table->string("tel");//电话
            $table->float("money",7,2);//订单总额
            $table->integer("ordtime");//下单时间
            $table->boolean("ispay");//支付状态
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
