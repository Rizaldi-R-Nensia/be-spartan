<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->increments('client_id');
            $table->string('client_name');
            $table->string('client_address');
            $table->string('client_picclient');
            $table->string('client_mobileclient');
            $table->string('client_image');
            $table->dateTime('client_crdate');
            $table->dateTime('client_update');
            $table->dateTime('client_dldate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client');
    }
}
