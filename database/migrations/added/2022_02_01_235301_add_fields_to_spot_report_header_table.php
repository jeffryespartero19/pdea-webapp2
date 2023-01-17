<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSpotReportHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spot_report_header', function (Blueprint $table) {
            $table->string('prelim_case_status')->nullable();
            $table->date('prelim_case_date')->nullable();
            $table->string('prelim_prosecutor')->nullable();
            $table->string('prelim_prosecutor_office')->nullable();
            $table->string('is_number')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('report_header')->nullable();
            $table->string('summary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spot_report_header', function (Blueprint $table) {
            $table->dropColumn('prelim_case_status');
            $table->dropColumn('prelim_case_date');
            $table->dropColumn('prelim_prosecutor');
            $table->dropColumn('prelim_prosecutor_office');
            $table->dropColumn('is_number');
            $table->dropColumn('reference_number');
            $table->dropColumn('report_header');
            $table->dropColumn('summary');
        });
    }
}
