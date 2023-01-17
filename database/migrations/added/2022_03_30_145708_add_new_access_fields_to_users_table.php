<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewAccessFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('with_geomapping_access')->default(0)->nullable;
            $table->boolean('with_file_upload_access')->default(0)->nullable;
            $table->boolean('with_drug_management_access')->default(0)->nullable;
            $table->boolean('with_drug_verification_access')->default(0)->nullable;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('with_geomapping_access');
            $table->dropColumn('with_file_upload_access');
            $table->dropColumn('with_drug_management_access');
            $table->dropColumn('with_drug_verification_access');
        });
    }
}
