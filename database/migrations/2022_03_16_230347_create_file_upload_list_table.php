<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileUploadListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_upload_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->integer('transaction_type')->default(0);
            $table->integer('preops_file_id')->default(0);
            $table->integer('after_operation_file_id')->default(0);
            $table->integer('spot_report_file_id')->default(0);
            $table->integer('progress_report_file_id')->default(0);
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
        Schema::dropIfExists('file_upload_list');
    }
}
