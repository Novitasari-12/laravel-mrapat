<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiPerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_perusahaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip_pegawai')->unique()->nullable();
            $table->string('nama_pegawai')->nullable();
            $table->string('bidang_pegawai')->nullable();
            $table->string('unit_pegawai')->nullable();
            $table->string('email_pegawai')->unique()->nullable();
            $table->string('no_telpon')->nullable();
            // ++++
            $table->string('password')->nullable()->default(Hash::make('pegawai'));
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
        Schema::dropIfExists('pegawai_perusahaan');
    }
}
