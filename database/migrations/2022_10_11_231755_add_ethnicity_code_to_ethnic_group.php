<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEthnicityCodeToEthnicGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ethnic_group', function (Blueprint $table) {
            $table->string('ethnicity_code')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ethnic_group', function (Blueprint $table) {
            $table->dropColumn('ethnicity_code');
        });
    }
}
