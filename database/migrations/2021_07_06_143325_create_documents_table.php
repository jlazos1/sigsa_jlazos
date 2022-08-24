<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string("type")->comment("Entrada, Salida");
            $table->string("documentType", 60)->comment("Factura, Boleta, Guia de Despacho, Otro");
            $table->integer("number")->nullable();
            $table->date("date")->nullable()->comment("Fecha de documento");
            $table->date("deliveryDate")->nullable()->comment("Fecha de entrega");
            $table->date("returnDate")->nullable()->comment("Fecha de devolución");
            $table->string("transmitterRut")->nullable();
            $table->string("transmitterName")->nullable();
            $table->string("transmitterAddress")->nullable();
            $table->string("transmitterCity")->nullable();
            $table->string("transmitterEmail")->nullable();
            $table->string("transmitterSale")->nullable();
            $table->string("receiverRut")->nullable();
            $table->string("receiverName")->nullable();
            $table->string("receiverAddress")->nullable();
            $table->string("receiverCity")->nullable();
            $table->string("receiverEmail")->nullable();
            $table->string("receiverSale")->nullable();
            $table->integer("net")->default(0)->comment("neto");
            $table->integer("tax")->default(0)->comment("impuesto");
            $table->integer("total")->default(0);
            // Convertirlos en claves foraneas de "places" pero con nombre origin y destination
            // $table->foreignId("origin")->constrained();
            // $table->foreignId("destination")->constrained();
            $table->timestamps();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('origin')->nullable();
            $table->foreign('origin')->references('id')->on('places');
            $table->unsignedBigInteger('destination')->nullable();
            $table->foreign('destination')->references('id')->on('places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
