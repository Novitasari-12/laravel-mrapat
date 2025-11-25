<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotulenRakerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notulen_raker', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_raker')->unsigned();
            $table->string('username')->nullable();
            $table->string('password')->unique()->nullable();
            $table->longText('hasil_raker')->nullable();
            $table->boolean('status_tulis')->default(1);
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
        Schema::dropIfExists('notulen_raker');
    }
}
