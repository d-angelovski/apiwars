<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiEndpoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_endpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('path', 150);
            $table->string('service', 150);
            $table->string('username', 150)->nullable(true)->default(null);
            $table->string('password', 150)->nullable(true)->default(null);
            $table->string('token', 150)->nullable(true)->default(null);
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
        Schema::dropIfExists('api_endpoints');
    }
}
