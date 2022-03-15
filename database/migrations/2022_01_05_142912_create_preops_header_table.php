<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreopsHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preops_header', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('preops_number', 50)->unique();
            $table->string('region_c', 50);
            $table->integer('operating_unit_id');
            $table->integer('operation_type_id');
            $table->dateTime('coordinated_datetime')->nullable();
            $table->string('duration', 50)->nullable();
            $table->dateTime('operation_datetime')->nullable();
            $table->dateTime('validity')->nullable();
            $table->string('remarks')->nullable();
            $table->string('reference_number', 50)->nullable();
            $table->string('prepared_by', 50)->nullable();
            $table->string('approved_by', 50)->nullable();
            $table->string('modified_by', 50)->nullable();
            $table->string('result')->nullable();
            $table->string('received_date')->nullable();
            $table->integer('negative_reason_id')->nullable();
            $table->string('module')->nullable();
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
        Schema::dropIfExists('preops_header');
    }
}
