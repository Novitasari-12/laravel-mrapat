<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaRakerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_raker', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_raker')->unsigned();
            $table->bigInteger('id_pegawai_perusahaan')->unsigned();
            $table->boolean('status_absensi')->default(0);
            $table->dateTime('tanggal_jam_absensi')->nullable();
            $table->string('keterangan_absensi')->nullable();
            $table->text('upload_foto')->nullable();
            $table->timestamps();

            $table->foreign('id_raker')->references('id')->on('raker')->onDelete('cascade');
            $table->foreign('id_pegawai_perusahaan')->references('id')->on('pegawai_perusahaan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peserta_raker');
    }
}
