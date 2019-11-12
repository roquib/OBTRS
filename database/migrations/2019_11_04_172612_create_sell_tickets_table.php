<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ticket_id')->unsigned();
            $table->integer('trip_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('seat_number');
            $table->integer('seat_available')->default(1);
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
        Schema::dropIfExists('sell_tickets');
    }
}
