<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCocSerialNumberToPreopsHeader extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preops_header', function (Blueprint $table) {
            $table->string('coc_serial_number')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preops_header', function (Blueprint $table) {
            $table->dropColumn('coc_serial_number');
        });
    }
}
