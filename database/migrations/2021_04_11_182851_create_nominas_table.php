<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominas', function (Blueprint $table) {
            $table->id();
            $table->string("curso")->nullable();
            $table->integer("number")->nullable();
            $table->string("matricula")->nullable();
            $table->string("run")->unique();
            $table->string("student")->nullable();
            $table->string("name1")->nullable();
            $table->string("name2")->nullable();
            $table->string("lastname1")->nullable();
            $table->string("lastname2")->nullable();
            $table->string("genre")->nullable();
            $table->date("birthday")->nullable();
            $table->string("obs")->nullable();
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
        Schema::dropIfExists('nominas');
    }
}
