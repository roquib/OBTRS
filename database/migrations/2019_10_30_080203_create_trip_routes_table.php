<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->string('company_name');
            $table->integer('origin_city_id');
            $table->integer('destination_city_id');
            $table->integer('parent_trip_route_id')->default(0);
            $table->decimal('business_class_fare', 8, 2)->default(0.00);
            $table->decimal('economy_class_fare', 8, 2)->default(0.00);
            $table->decimal('special_class_fare', 8, 2)->default(0.00);
            $table->string('departure_date');
            $table->string('departure_time');
            $table->string('arrival_date');
            $table->string('arrival_time');
            $table->string('trip_number');
            $table->integer('bus_type_id');
            $table->string('bus_desc');
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
        Schema::dropIfExists('trip_routes');
    }
}
