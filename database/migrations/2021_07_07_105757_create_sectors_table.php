<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->string("name", 60)->comment("Sector A, Sector B, etc.");
            $table->string("char", 1)->comment("A, B, L, F");
            $table->string("type", 60)->comment("Sala, Laboratorio, Oficina, Bodega");
            $table->integer("start");
            $table->integer("end");
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
        Schema::dropIfExists('sectors');
    }
}
