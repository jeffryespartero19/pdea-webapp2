<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLaboratoryFacilityCodeToLaboratoryFacility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laboratory_facility', function (Blueprint $table) {
            $table->string('laboratory_facility_code')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laboratory_facility', function (Blueprint $table) {
            $table->dropColumn('laboratory_facility_code');

        });
    }
}
