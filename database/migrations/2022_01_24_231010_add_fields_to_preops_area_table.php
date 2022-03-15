<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPreopsAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preops_area', function (Blueprint $table) {
            $table->string('region_c')->nullable();
            $table->string('province_c')->nullable();
            $table->string('city_c')->nullable();
            $table->string('barangay_c')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preops_area', function (Blueprint $table) {
            $table->dropColumn('region_c');
            $table->dropColumn('province_c');
            $table->dropColumn('city_c');
            $table->dropColumn('barangay_c');
        });
    }
}
