<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilehistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profilehistories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('vendor_id')->unsigned();
            $table->string('name');
            $table->text('address');
            $table->string('country');
            $table->string('url');
            $table->string('cac');
            $table->string('workforce');
            $table->string('yearsofexp');
            $table->string('ratings');
           /* $table->string('contactname');
            $table->string('contactphone');
            $table->string('contactemail');
            $table->string('chairmanname');
            $table->string('chairmanphone');
            $table->string('chairmanemail'); */
            $table->integer('producttype');
            $table->integer('location');
            $table->string('vendor_type');
            $table->boolean('edits')->default(0);
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
        Schema::dropIfExists('profilehistories');
    }
}
