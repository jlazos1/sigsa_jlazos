<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("proxy_id")->nullable()->constrained();
            $table->foreignId("student_id")->nullable()->constrained();
            $table->foreignId("user_id")->nullable()->constrained();
            $table->integer("user_sigsa")->nullable();
            $table->date("delivery")->nullable();
            $table->date("return")->nullable();
            $table->text("voucher")->nullable()->comment("Imagen del comprobante");
            $table->boolean("confirmed")->default(false);
            $table->dateTime("returned")->nullable();
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
        Schema::dropIfExists('loans');
    }
}
