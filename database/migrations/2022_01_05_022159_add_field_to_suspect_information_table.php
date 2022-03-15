<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToSuspectInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suspect_information', function (Blueprint $table) {
            $table->longText('photo')->nullable();
            $table->string('region_c')->nullable();
            $table->string('province_c')->nullable();
            $table->string('city_c')->nullable();
            $table->string('barangay_c')->nullable();
            $table->integer('operation_classification_id');
            $table->date('operation_date')->nullable();
            $table->string('operation_region');
            $table->integer('operating_unit_id');
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
            $table->dropColumn('photo');
            $table->dropColumn('region_c');
            $table->dropColumn('province_c');
            $table->dropColumn('city_c');
            $table->dropColumn('barangay_c');
            $table->dropColumn('operation_classification_id');
            $table->dropColumn('operation_date');
            $table->dropColumn('operation_region');
            $table->dropColumn('operating_unit_id');
        });
    }
}
