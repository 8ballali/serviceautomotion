<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id', 36)->primary();
            $table->string('blok');
            $table->integer('no_kavling')->unsigned();
            $table->integer('type');
            $table->integer('luas_tanah')->unsigned();
            $table->integer('price');
            $table->string('status');
            $table->integer('tanah_lebih')->unsigned()->nullable();
            $table->integer('discount')->unsigned()->nullable();
            $table->string('image')->nullable();
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
};
