<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Customers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function($table)
        {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->string('name');
            $table->string('user_type');
            $table->text('about');
            $table->string('website');
            $table->string('businesstype');
            $table->string('cac');
            $table->string('yearsofexitence');
            $table->string('mdname');
            $table->string('mdtel');
            $table->string('mdemail');
            $table->string('contactperson');
            $table->string('contactpersontel');
            $table->string('contactpersonemail');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address_2')->nullable();
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_address_2')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('same_billing')->default(1);

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
        Schema::drop('customers');
    }
}
