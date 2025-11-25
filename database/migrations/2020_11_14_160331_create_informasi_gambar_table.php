<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformasiGambarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informasi_gambar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->string('gambar')->nullable();
            $table->text('informasi_gambar')->nullable();
            $table->dateTime('waktu_mulai_ditampilkan')->nullable();
            $table->dateTime('waktu_selesai_ditampilkan')->nullable();
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
        Schema::dropIfExists('informasi_gambar');
    }
}
