<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNullableToProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proxies', function (Blueprint $table) {
            $table->string("name2", 50)->nullable()->change();
            $table->string("phone1")->nullable()->change();
            $table->string("phone2")->nullable()->change();
            $table->string("email")->nullable()->change();
            $table->string("address")->nullable()->change();
            $table->string("city")->nullable()->change();
            $table->string("country")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proxies', function (Blueprint $table) {
            //
        });
    }
}
