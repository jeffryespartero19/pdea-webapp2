<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToDrugType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drug_type', function (Blueprint $table) {
            $table->string('sub_category');
            $table->float('unit_measurement', 10, 4)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drug_type', function (Blueprint $table) {
            $table->dropColumn('sub_category');
            $table->dropColumn('unit_measurement');
        });
    }
}
