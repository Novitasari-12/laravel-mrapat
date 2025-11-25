<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersetujuanRakerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persetujuan_raker', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_sekretaris_bidang')->unsigned();
            $table->bigInteger('id_raker')->unsigned()->unique();
            $table->boolean('status_persetujuan_raker')->default(0);
            $table->text('deskripsi_persetujuan_raker');
            $table->timestamps();

            $table->foreign('id_sekretaris_bidang')->references('id')->on('sekretaris_bidang')->onDelete('cascade');
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
        Schema::dropIfExists('persetujuan_raker');
    }
}
