<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSpotReportSuspectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spot_report_suspect', function (Blueprint $table) {
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('alias');
            $table->string('gender');
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('civil_status_id')->nullable();
            $table->integer('religion_id')->nullable();
            $table->integer('educational_attainment_id')->nullable();
            $table->integer('ethnic_group_id')->nullable();
            $table->integer('occupation_id')->nullable();
            $table->string('region_c')->nullable();
            $table->string('province_c')->nullable();
            $table->string('city_c')->nullable();
            $table->string('barangay_c')->nullable();
            $table->string('street')->nullable();
            $table->string('permanent_region_c')->nullable();
            $table->string('permanent_province_c')->nullable();
            $table->string('permanent_city_c')->nullable();
            $table->string('permanent_barangay_c')->nullable();
            $table->string('permanent_street')->nullable();
            $table->boolean('status')->default(0);
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
            $table->dropColumn('lastname');
            $table->dropColumn('firstname');
            $table->dropColumn('middlename');
            $table->dropColumn('alias');
            $table->dropColumn('gender');
            $table->dropColumn('birthdate');
            $table->dropColumn('birthplace');
            $table->dropColumn('nationality_id');
            $table->dropColumn('civil_status_id');
            $table->dropColumn('religion_id');
            $table->dropColumn('educational_attainment_id');
            $table->dropColumn('ethnic_group_id');
            $table->dropColumn('occupation_id');
            $table->dropColumn('region_c');
            $table->dropColumn('province_c');
            $table->dropColumn('city_c');
            $table->dropColumn('barangay_c');
            $table->dropColumn('street');
            $table->dropColumn('permanent_region_c');
            $table->dropColumn('permanent_province_c');
            $table->dropColumn('permanent_city_c');
            $table->dropColumn('permanent_barangay_c');
            $table->dropColumn('permanent_street');
            $table->dropColumn('status');
        });
    }
}
