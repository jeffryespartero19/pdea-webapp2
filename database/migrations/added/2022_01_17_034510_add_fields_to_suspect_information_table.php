<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSuspectInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suspect_information', function (Blueprint $table) {
            $table->string('permanent_region_c')->nullable();
            $table->string('permanent_province_c')->nullable();
            $table->string('permanent_city_c')->nullable();
            $table->string('permanent_barangay_c')->nullable();
            $table->string('permanent_street')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suspect_information', function (Blueprint $table) {
            $table->dropColumn('permanent_region_c');
            $table->dropColumn('permanent_province_c');
            $table->dropColumn('permanent_city_c');
            $table->dropColumn('permanent_barangay_c');
            $table->dropColumn('permanent_street');
        });
    }
}
