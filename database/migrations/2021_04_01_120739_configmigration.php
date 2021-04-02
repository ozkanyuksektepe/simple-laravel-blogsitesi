<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Configmigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->integer('active')->default(1);
            $table->integer('facebook')->nullable();
            $table->integer('twitter')->nullable();
            $table->integer('github')->nullable();
            $table->integer('linkedin')->nullable();
            $table->integer('youtube')->nullable();
            $table->integer('instagram')->nullable();
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
        Schema::dropIfExists('configs');
    }
}
