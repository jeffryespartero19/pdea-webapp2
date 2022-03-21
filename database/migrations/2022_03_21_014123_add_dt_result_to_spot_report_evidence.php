<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDtResultToSpotReportEvidence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spot_report_evidence', function (Blueprint $table) {
            $table->string('drug_test_result')->nullable();
            $table->integer('laboratory_facility_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spot_report_evidence', function (Blueprint $table) {
            $table->dropColumn('drug_test_result');
            $table->dropColumn('laboratory_facility_id');
        });
    }
}
