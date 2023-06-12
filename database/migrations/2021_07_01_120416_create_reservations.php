<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vehicle_id')->unsigned();
            $table->foreign('vehicle_id')->references('id')
                ->on('vehicles')
                ->onDelete('cascade');
            $table->date('reservation_date');
            $table->string('reservation_time')->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('return_location')->nullable();
            $table->string('total_customer')->nullable();
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->integer('source_id')->unsigned();
            $table->foreign('source_id')->references('id')
                ->on('sources')
                ->onDelete('cascade');
            $table->integer('route_type_id')->unsigned();
            $table->foreign('route_type_id')->references('id')
                ->on('route_types')
                ->onDelete('cascade');
            $table->integer('sales_person_id')->unsigned();
            $table->foreign('sales_person_id')->references('id')
                ->on('sales_persons')
                ->onDelete('cascade');
            $table->longText('reservation_note')->nullable();
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
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
