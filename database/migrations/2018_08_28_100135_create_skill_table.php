<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill', function (Blueprint $table) {
            $table->increments('skill_id'); //primary key
            $table->unsignedinteger('skilltype_id'); //foreign key
            $table->string('skill_name');
            $table->dateTime('skill_crdate');
            $table->dateTime('skill_update');
            $table->dateTime('skill_dldate');

            // $table->foreign('skilltype_id')->references('id')->on('skilltype');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skill');
    }
}
