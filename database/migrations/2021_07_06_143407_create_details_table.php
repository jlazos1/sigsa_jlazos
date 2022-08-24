<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("document_id")->constrained();
            $table->foreignId("product_id")->nullable();
            $table->foreignId("active_id")->nullable();
            $table->foreignId("place_id")->constrained();
            $table->integer("qty");
            $table->integer("price")->nullable();
            $table->timestamps();

            $table->foreign("product_id")->references("id")->on("products");
            $table->foreign("active_id")->references("id")->on("actives");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details');
    }
}
