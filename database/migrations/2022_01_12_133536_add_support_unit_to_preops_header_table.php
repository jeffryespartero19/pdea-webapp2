<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupportUnitToPreopsHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preops_header', function (Blueprint $table) {
            $table->string('support_unit')->nullable();
            $table->date('date_reported')->nullable();
            $table->string('filename')->nullable();
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
            $table->dropColumn('support_unit');
            $table->dropColumn('date_reported');
            $table->dropColumn('filename');
        });
    }
}
