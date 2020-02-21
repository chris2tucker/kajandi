<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsconditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('termsconditions', function (Blueprint $table) {
            $table->increments('id');
            $table->LongText('terms')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
          // Fill user permissions
      DB::table('termsconditions')->insert(
        array(
          'id' => '1',
          'description' => 'customer'
        )
      );

      DB::table('termsconditions')->insert(
        array(
          'id' => '2',
          'description' => 'vendor'
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
        Schema::dropIfExists('termsconditions');
    }
}
