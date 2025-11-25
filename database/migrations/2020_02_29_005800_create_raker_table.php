<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRakerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raker', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_sekretaris_bidang')->unsigned();
            $table->bigInteger('id_ruangan')->unsigned();
            $table->string('nama_raker')->nullable();
            $table->string('deskripsi_raker')->nullable();
            $table->dateTime('tanggal_jam_masuk_raker')->nullable();
            $table->dateTime('tanggal_jam_keluar_raker')->nullable();
            $table->integer('jumlah_peserta_raker')->nullable();
            $table->timestamps();

            $table->foreign('id_sekretaris_bidang')->references('id')->on('sekretaris_bidang')->onDelete('cascade');
            $table->foreign('id_ruangan')->references('id')->on('ruangan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raker');
    }
}
