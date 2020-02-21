<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vendorproduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendorproduct', function($table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->double('price');
            $table->text('remark');
            $table->string('payondelivery');
            $table->string('availability');
            $table->integer('category')->unsigned();
            $table->foreign('category')->references('id')->on('categories');
            $table->integer('subcategory')->unsigned();
            $table->foreign('subcategory')->references('id')->on('subcategories');
            $table->integer('addon_id')->unsigned();
            $table->foreign('addon_id')->references('id')->on('productaddon');
            $table->integer('model_id')->unsigned();
            $table->foreign('model_id')->references('id')->on('productmodel');
            $table->integer('source_id')->unsigned();
            $table->foreign('source_id')->references('id')->on('source');
            $table->integer('manufacturer_id')->unsigned();
            $table->boolean('promotion')->default(0);
            $table->foreign('manufacturer_id')->references('id')->on('productmanufacturer');
            $table->integer('condition_id')->unsigned();
            $table->foreign('condition_id')->references('id')->on('condition');
            $table->string('valueanalysis');
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
        Schema::drop('vendorproduct');
    }
}
