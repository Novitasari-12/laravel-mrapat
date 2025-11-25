<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasilitasPendukungRakerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fasilitas_pendukung_raker', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_raker')->unsigned();
            $table->string('fasilitas_pendukung')->nullable();
            $table->timestamps();

            $table->foreign('id_raker')->references('id')->on('raker')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fasilitas_pendukung_raker');
    }
}
