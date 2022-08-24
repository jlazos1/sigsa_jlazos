<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actives', function (Blueprint $table) {
            $table->id()->from(1000);
            $table->string("item", 60)->nullable();
            $table->foreignId("place_id")->nullable();
            $table->string("model", 60)->nullable();
            $table->string("sku", 100)->unique()->nullable();
            $table->string("serial_number", 100)->nullable();
            $table->string("brand", 100)->nullable();
            $table->unsignedBigInteger("document_id");
            $table->string("department", 50)->nullable();
            $table->string("observation", 300)->nullable();
            $table->timestamps();

            $table->foreign("document_id")->references("id")->on("documents");
            $table->foreign("place_id")->references("id")->on("places");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actives');
    }
}
