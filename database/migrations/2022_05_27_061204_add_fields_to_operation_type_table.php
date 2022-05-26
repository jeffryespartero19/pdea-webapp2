<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToOperationTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operation_type', function (Blueprint $table) {
            $table->integer('operation_category_id');
            $table->boolean('show_preops')->default(0)->nullable;
            $table->boolean('show_spot_report')->default(0)->nullable;
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
            $table->dropColumn('operation_category_id');
            $table->dropColumn('show_preops');
            $table->dropColumn('show_spot_report');
        });
    }
}
