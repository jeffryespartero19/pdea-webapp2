<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrintCountToSpotReportHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spot_report_header', function (Blueprint $table) {
            $table->integer('print_count')->default(0);
            $table->datetime('print_date')->nullable();
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
            $table->dropColumn('print_count');
        });
    }
}
