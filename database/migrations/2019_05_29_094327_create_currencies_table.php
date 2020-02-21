<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->float('Dollar');
            $table->float('Euro');
            $table->float('Yen');

            $table->timestamps();
        });
        DB::table('currencies')->insert(
        array(
          'id' => '1',
          'Dollar' => 2.1,
          'Euro'=>1.1,
          'Yen'=>22
        )
      );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
