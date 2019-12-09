<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("p_name");
            $table->string("p_gender");
            $table->string("p_mobile");
            $table->string("p_email");
            $table->string("trip_id");
            $table->string("origin_city_name");
            $table->string("destination_city_name");
            $table->string("company_name");
            $table->string("departure_date");
            $table->string("departure_time");
            $table->string('ticket_one')->nullable();
            $table->string('ticket_two')->nullable();
            $table->string('ticket_three')->nullable();
            $table->string("boarding_point");
            $table->string("total");
            $table->string("payment");
            $table->string("city");
            $table->string("area");
            $table->string("first_name");
            $table->string("last_name");
            $table->string("address");
            $table->string("alternate_contact");
            $table->boolean('status', 1)->default(0);
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
        Schema::dropIfExists('reservations');
    }
}
