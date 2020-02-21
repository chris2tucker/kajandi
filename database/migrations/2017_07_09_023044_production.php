<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Production extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('image');
            $table->string('partnumber');
            $table->text('description');
            $table->text('unit');
            $table->text('weight');
            $table->text('length');
            $table->integer('category')->unsigned();
            $table->foreign('category')->references('id')->on('categories');
            $table->integer('subcategory')->unsigned();
            $table->foreign('subcategory')->references('id')->on('subcategories');
            $table->integer('manufacturer')->unsigned();
            $table->foreign('manufacturer')->references('id')->on('productmanufacturer');
            $table->integer('model')->unsigned();
            $table->foreign('model')->references('id')->on('productmodel');
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
        Schema::dropIfExists('products');
    }
}
