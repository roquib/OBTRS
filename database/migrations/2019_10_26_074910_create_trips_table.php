<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->integer('id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
