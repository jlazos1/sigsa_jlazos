<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name", 60);
            $table->text("description")->nullable();
            $table->foreignId("product_type_id")->constrained();
            $table->string("model", 60)->nullable();
            $table->string("sku", 100)->unique()->nullable();
            $table->string("code", 100)->nullable();
            $table->string("brand", 100)->nullable();
            $table->integer("priceBuy")->nullable();
            $table->integer("priceSale")->nullable();
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
        Schema::dropIfExists('products');
    }
}
