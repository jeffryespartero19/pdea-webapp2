<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEducationalAttainmentCodeToEducationalAttainment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educational_attainment', function (Blueprint $table) {
            $table->string('educational_attainment_code')->after('id')->nullable();
        });
        // educational_attainment_code
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('educational_attainment', function (Blueprint $table) {
            $table->dropColumn('educational_attainment_code');
        });
    }
}
