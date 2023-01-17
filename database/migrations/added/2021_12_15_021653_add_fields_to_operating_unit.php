<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToOperatingUnit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operating_unit', function (Blueprint $table) {
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
        Schema::table('operating_unit', function (Blueprint $table) {
            $table->dropColumn('province_c');
            $table->dropColumn('city_c');
        });
    }
}
