<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpotReportHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spot_report_header', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('spot_report_number', 50)->unique();
            $table->string('preops_number', 50);
            $table->string('region_c', 50);
            $table->string('province_c', 50);
            $table->date('reported_date')->nullable();
            $table->dateTime('operation_datetime')->nullable();
            $table->integer('operation_type_id');
            $table->integer('operating_unit_id');
            $table->date('progress_reported_date')->nullable();
            $table->date('case_status_date')->nullable();
            $table->longText('procecutor_name')->nullable();
            $table->longText('procecutor_office')->nullable();
            $table->string('docket_number', 50)->nullable();
            $table->longText('judge_name')->nullable();
            $table->longText('branch')->nullable();
            $table->longText('remarks')->nullable();
            $table->string('case_status', 50)->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->string('approved_by', 50)->nullable();
            $table->string('modified_by', 50)->nullable();
            $table->string('warrant_number')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('spot_report_header');
    }
}
