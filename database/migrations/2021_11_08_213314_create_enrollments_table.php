<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("course_id")->constrained();
            $table->integer("numberList")->comment("Número de Lista")->nullable();
            $table->foreignId("student_id")->constrained();
            $table->integer("numberRecord")->comment("Número de Matrícula")->nullable();
            $table->integer("year")->default(2021);
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
        Schema::dropIfExists('enrollments');
    }
}
