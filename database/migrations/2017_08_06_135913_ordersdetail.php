<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ordersdetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordersdetail', function($table)
        {
            $table->increments('id');
            $table->integer('order_id')->unique();
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('vendorproduct');
            $table->double('price');
            $table->integer('quantity');
            $table->double('totalprice');
            $table->string('sku');
            $table->string('color');
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
        Schema::drop('ordersdetail');
    }
}
