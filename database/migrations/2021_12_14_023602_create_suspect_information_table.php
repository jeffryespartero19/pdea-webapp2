<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuspectInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspect_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('suspect_number')->unique();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('alias');
            $table->string('gender');
            $table->date('birthdate');
            $table->string('birthplace');
            $table->integer('nationality_id');
            $table->integer('civil_status_id');
            $table->integer('religion_id');
            $table->integer('educational_attainment_id');
            $table->integer('ethnic_group_id');
            $table->integer('occupation_id');
            $table->integer('monthly_income');
            $table->string('region_c');
            $table->string('province_c');
            $table->string('city_c');
            $table->string('barangay_c');
            $table->string('street');
            $table->integer('identifier_id');
            $table->integer('suspect_classification_id');
            $table->integer('group_affiliation_id');
            $table->string('drug_group');
            $table->string('remarks');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suspect_information');
    }
}
