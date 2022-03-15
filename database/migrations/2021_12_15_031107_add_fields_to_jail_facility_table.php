<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToJailFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jail_facility', function (Blueprint $table) {
            $table->string('region_c');
            $table->string('province_c');
            $table->string('city_c');
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
            $table->dropColumn('region_c');
            $table->dropColumn('province_c');
            $table->dropColumn('city_c');
        });
    }
}
