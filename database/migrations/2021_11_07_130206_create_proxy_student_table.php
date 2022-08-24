<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProxyStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxy_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId("proxy_id")->constrained();
            $table->string("relationship")->comment("Relación : Padre, Madre, Tio, Abuela, etc.");
            $table->foreignId("student_id")->constrained();
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
        Schema::dropIfExists('proxy_student');
    }
}
