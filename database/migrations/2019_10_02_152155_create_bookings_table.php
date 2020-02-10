<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id');
            $table->integer('user_id');
            $table->integer('provider_id');
            $table->integer('space_id');
            $table->text('description')->nullable();
            $table->dateTime('checkin')->nullable();
            $table->dateTime('checkout')->nullable();
            $table->string('duartion')->default(0);
            $table->string('total_time')->default(0);
            $table->float('per_hour')->default(0.00);
            $table->string('currency')->default("$");
            $table->float('total')->default(0.00);
            $table->string('payment_mode')->default(COD);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('bookings');
    }
}
