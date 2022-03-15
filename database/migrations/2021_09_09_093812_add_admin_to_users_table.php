<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('with_coc_access')->default(0)->nullable();
            $table->boolean('with_sap_access')->default(0)->nullable;
            $table->boolean('with_settings_access')->default(0)->nullable;
            $table->boolean('is_admin')->default(0)->nullable;
            $table->boolean('is_applicant')->default(0)->nullable;
            $table->boolean('is_student')->default(0)->nullable;
            $table->string('photo')->nullable();
            $table->boolean('active')->nullable();
            $table->boolean('locked')->nullable();
            $table->datetime('locked_date')->nullable();
            $table->string('employee_no')->nullable();
            $table->string('applicant_no')->nullable();
            $table->string('student_no')->nullable();
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
            $table->dropColumn('with_coc_access');
            $table->dropColumn('with_sap_access');
            $table->dropColumn('with_settings_access');
            $table->dropColumn('is_admin');
            $table->dropColumn('is_applicant');
            $table->dropColumn('is_student');
            $table->dropColumn('photo');
            $table->dropColumn('active');
            $table->dropColumn('locked');
            $table->dropColumn('locked_date');
            $table->dropColumn('employee_no');
            $table->dropColumn('applicant_no');
            $table->dropColumn('student_no');
        });
    }
}
