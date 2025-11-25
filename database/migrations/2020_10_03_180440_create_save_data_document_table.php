<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSaveDataDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_data_document', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->nullable();
            $table->string('original_name')->nullable();
            $table->string('mime_type')->nullable();
            switch (env('DB_CONNECTION')) {
                case 'pgsql':
                    $table->longText('value')->nullable();
                    break;

                default:
                    $table->binary('value')->nullable();
                    break;
            }
            $table->timestamps();
        });

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('ALTER TABLE save_data_document MODIFY COLUMN value LONGBLOB');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_data_document');
    }
}
