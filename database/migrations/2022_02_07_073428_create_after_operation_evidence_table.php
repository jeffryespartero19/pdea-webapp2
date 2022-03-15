<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAfterOperationEvidenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('after_operation_evidence', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('preops_number');
            $table->string('illegal_drug')->nullable();
            $table->string('quantity')->nullable();
            $table->integer('unit_measurement_id')->nullable();
            $table->string('chemist_report_number')->nullable();
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
        Schema::dropIfExists('after_operation_evidence');
    }
}
