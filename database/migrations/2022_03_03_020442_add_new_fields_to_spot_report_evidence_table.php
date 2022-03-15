<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToSpotReportEvidenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spot_report_evidence', function (Blueprint $table) {
            $table->decimal('qty_onsite', 11, 4)->default(0);
            $table->decimal('actual_qty', 11, 4)->default(0);
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
            $table->dropColumn('qty_onsite');
            $table->dropColumn('actual_qty');
        });
    }
}
