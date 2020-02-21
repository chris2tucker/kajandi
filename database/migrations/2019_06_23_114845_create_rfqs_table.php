<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRfqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfqs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('product_name')->nullable();
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->string('generic_name')->nullable();
            $table->string('file')->nullable();
            $table->string('orders')->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('duration')->nullable();
            $table->string('paymentMethod')->nullable();
            $table->string('bussinus_email')->nullable();
            $table->string('product_certificate')->nullable();
            $table->string('company_certificate')->nullable();
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
        Schema::dropIfExists('rfqs');
    }
}
