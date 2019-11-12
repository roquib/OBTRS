<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('trip_id');
            $table->integer('trip_route_id');
            $table->integer('company_id');
            $table->string('company_name');
            $table->string('image')->nullable();
            $table->integer('origin_city_id');
            $table->string('origin_city_name');
            $table->integer('destination_city_id');
            $table->string('destination_city_name');
            $table->integer('parent_trip_route_id')->default(0);
            $table->decimal('business_class_fare', 8, 2)->default(0.00);
            $table->decimal('economy_class_fare', 8, 2)->default(0.00);
            $table->decimal('special_class_fare', 8, 2)->default(0.00);
            $table->string('departure_date');
            $table->string('departure_time');
            $table->string('arrival_date');
            $table->string('arrival_time');
            $table->string('available_till_datetime');
            $table->integer('bus_type_id')->nullable();
            $table->string('trip_number');
            $table->string('trip_heading');
            $table->string('bus_desc');
            $table->integer('available_seats')->default(40);
            $table->string('trip_origin_date');
            $table->string('trip_origin_time');
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
        Schema::dropIfExists('details');
    }
}
