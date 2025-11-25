<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_level')->unsigned();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('token_user_validate')->nullable();
            $table->boolean('status_user')->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_level')->references('id')->on('level')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
