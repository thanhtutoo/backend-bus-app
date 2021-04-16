<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusTimingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_timings', function (Blueprint $table) {
            $table->id();
            $table->timestamps('bus_stop_name');
            $table->foreign('bus_id')->references('bus_id')->on('buses')->onDelete('cascade');
            $table->foreign('bus_stop_id')->references('bus_stop_id')->on('bus_stops')->onDelete('cascade');
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
        Schema::dropIfExists('bus_timings');
    }
}
