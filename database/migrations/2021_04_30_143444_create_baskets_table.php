<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baskets', function (Blueprint $table) {
            $table->id();
            $table->string("course", 30);
            $table->string("email")->nullable();
            $table->string("run");
            $table->string("student")->comment("Nombre completo beneficiario");
            $table->string("observations");
            $table->string("personName")->comment("Nombre persona quien retira");
            $table->string("personRun")->comment("Run persona quien retira");
            $table->timestamps();
            $table->foreignId("user_id")->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baskets');
    }
}
