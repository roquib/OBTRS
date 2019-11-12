<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boardings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location_id');
            $table->string('location_name');
            $table->integer('location_status')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('trip_id');
            $table->integer('trip_point_id')->nullable();
            $table->integer('location_type')->nullable();
            $table->string('location_date')->nullable();
            $table->string('location_time')->nullable();
            $table->integer('counter_id')->nullable();
            $table->string('counter_name')->nullable();
            $table->string('counter_address')->nullable();
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
        Schema::dropIfExists('boardings');
    }
}
