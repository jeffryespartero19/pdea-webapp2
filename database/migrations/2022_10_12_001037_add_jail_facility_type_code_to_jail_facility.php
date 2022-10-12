<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJailFacilityTypeCodeToJailFacility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jail_facility', function (Blueprint $table) {
            $table->string('jail_facility_code')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jail_facility', function (Blueprint $table) {
            $table->dropColumn('jail_facility_code');
        });
    }
}
