<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuscatToSpotReportSuspectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spot_report_suspect', function (Blueprint $table) {
            $table->integer('suspect_sub_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spot_report_suspect', function (Blueprint $table) {
            $table->dropColumn('suspect_sub_category_id');
        });
    }
}
