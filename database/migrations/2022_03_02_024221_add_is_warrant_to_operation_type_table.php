<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsWarrantToOperationTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operation_type', function (Blueprint $table) {
            $table->boolean('is_warrant')->default(0);
            $table->boolean('is_testbuy')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operation_type', function (Blueprint $table) {
            $table->dropColumn('is_warrant');
            $table->dropColumn('is_testbuy');
        });
    }
}
