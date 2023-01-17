<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSpotReportEvidenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spot_report_evidence', function (Blueprint $table) {
            $table->string('initial_weight')->nullable();
            $table->string('breakdown')->nullable();
            $table->string('lab_test_weight')->nullable();
            $table->string('lab_test_result')->nullable();
            $table->string('value')->nullable();

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
            $table->dropColumn('initial_weight');
            $table->dropColumn('breakdown');
            $table->dropColumn('lab_test_weight');
            $table->dropColumn('lab_test_result');
            $table->dropColumn('value');
        });
    }
}
