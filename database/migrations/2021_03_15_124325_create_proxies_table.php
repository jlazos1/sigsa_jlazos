<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxies', function (Blueprint $table) {
            $table->id();
            $table->string("run", 15)->unique();
            $table->string("name1", 50);
            $table->string("name2", 50);
            $table->string("lastname1", 60);
            $table->string("lastname2", 60);
            $table->string("phone1");
            $table->string("phone2");
            $table->string("email");
            $table->string("address");
            $table->string("city");
            $table->string("country");
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
        Schema::dropIfExists('proxies');
    }
}
